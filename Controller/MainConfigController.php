<?php

namespace CPASimUSante\ItemSelectorBundle\Controller;

use CPASimUSante\ItemSelectorBundle\Entity\MainConfig;
use CPASimUSante\ItemSelectorBundle\Form\MainConfigType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\DiExtraBundle\Annotation as DI;
use CPASimUSante\ItemSelectorBundle\Manager\ItemSelectorManager;

/**
 * Class MainConfigController.
 *
 * @category   Controller
 *
 * @author     CPASimUSante <contact@simusante.com>
 * @copyright  2015 CPASimUSante
 * @license    http://www.opensource.org/licenses/mit-license.php MIT License
 *
 * @version    0.1
 *
 * @link       http://simusante.com
 *
 * @EXT\Route(
 *      "/config",
 *      name    = "cpasimusante_itemselector_mainconfig",
 *      service = "cpasimusante_itemselector.controller.mainconfig"
 * )
 */
class MainConfigController extends Controller
{
    protected $manager;

    /**
     * @DI\InjectParams({
     *      "manager" = @DI\Inject("cpasimusante_itemselector.manager.plugin.itemselector"),
     * })
     */
    public function __construct(ItemSelectorManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Configuration.
     *
     * @EXT\Route("/choose", name="cpasimusante_mainconfig", options={"expose"=true})
     * @EXT\Template("CPASimUSanteItemSelectorBundle::config.html.twig")
     */
    public function adminOpenAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $mainConfig = $this->manager->getMainConfig();

        // Create an ArrayCollection of the current Item objects in the database
        $originalItems = new ArrayCollection();
        foreach ($mainConfig->getItems() as $item) {
            $originalItems->add($item);
        }

        //working because call service_container in controller.yml
        $form = $this->get('form.factory')
            ->create(new MainConfigType(), $mainConfig);
        $form->handleRequest($request);

        if ($form->isValid()) {
            // remove the relationship between the item and the ItemSelector
            foreach ($originalItems as $item) {
                if (false === $mainConfig->getItems()->contains($item)) {
                    // in a a many-to-one relationship, remove the relationship
                    $item->setMainconfig(null);
                    $em->persist($item);
                    // to delete the Item entirely, you can also do that
                    $em->remove($item);
                }
            }
            $em->persist($mainConfig);
            $em->flush();
        }

        return [
            'form' => $form->createView(),
        ];
    }
}
