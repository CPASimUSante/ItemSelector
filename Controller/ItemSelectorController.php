<?php

namespace CPASimUSante\ItemSelectorBundle\Controller;

use CPASimUSante\ItemSelectorBundle\Entity\Item;
use CPASimUSante\ItemSelectorBundle\Entity\ItemSelector;
use CPASimUSante\ItemSelectorBundle\Form\ItemSelectorType;
use CPASimUSante\ItemSelectorBundle\Manager\ItemSelectorManager;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ItemSelectorController.
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
 *      "/",
 *      name    = "cpasimusante_itemselector",
 *      service = "cpasimusante_itemselector.controller.itemselector"
 * )
 */
class ItemSelectorController extends Controller
{
    private $itemSelectorManager;

    /**
     * @DI\InjectParams({
     *     "itemSelectorManager" = @DI\Inject("cpasimusante_itemselector.manager.itemselector")
     * })
     *
     * @param ItemSelectorManager   itemSelectorManager
     */
    public function __construct(
        ItemSelectorManager $itemSelectorManager
    ) {
        $this->itemSelectorManager = $itemSelectorManager;
    }

    /**
     * Show main page.
     *
     * @EXT\Route("/choose/{id}", name="cpasimusante_choose_item", requirements={"id" = "\d+"}, options={"expose"=true})
     * @EXT\ParamConverter("itemselector", class="CPASimUSanteItemSelectorBundle:ItemSelector", options={"id" = "id"})
     * @EXT\Template("CPASimUSanteItemSelectorBundle:ItemSelector:choose.html.twig")
     *
     * @param Request      $request
     * @param ItemSelector $itemSelector
     *
     * @return array
     */
    public function chooseAction(Request $request, ItemSelector $itemSelector)
    {
        //can user access ?
        $this->checkAccess('OPEN', $itemSelector);

        //retrieve ItemSelector configuration for this WS
        $config = $this->getConfig($itemSelector->getResourceNode()->getWorkspace()->getId());

        $mainResourceType = $config['mainResourceType'];
        $resourceType = $config['resourceType'];
        $namePattern = $config['namePattern'];
/*
        $em = $this->getDoctrine()->getManager();

        // Create an ArrayCollection of the current Item objects in the database
        $originalItems = new ArrayCollection();
        foreach ($itemSelector->getItems() as $item) {
            $originalItems->add($item);
        }

        $form = $this->get('form.factory')
            ->create(new ItemSelectorType($mainResourceType, $resourceType, $namePattern), $itemSelector);
        $form->handleRequest($request);

        if ($form->isValid()) {
            // remove the relationship between the item and the ItemSelector
            foreach ($originalItems as $item) {
                if (false === $itemSelector->getItems()->contains($item)) {
                    // in a many-to-one relationship, remove the relationship
                    $item->setItemSelector(null);
                    $em->persist($item);
                    // to delete the Item entirely, you can also do that
                    $em->remove($item);
                }
            }

            $em->persist($itemSelector);
            $em->flush();
        }
*/

        $items = $this->itemSelectorManager->getItems($itemSelector);
        //retrieve the list of items to be displayed in the item select
        $itemlist = $this->itemSelectorManager->getAuthorizedItemList($resourceType, $namePattern, 'name');

        return [
            'mainResourceType' => $mainResourceType,
            '_resource' => $itemSelector,
            'itemSelector' => $items,
            'itemList' => $itemlist,
            'itemCount' => $config['itemCount'],
  //'form' => $form->createView(),
        ];
    }

    /**
     * retrieve configuration for this WS.
     *
     * @param $workspace
     *
     * @return array
     */
    private function getConfig($workspace)
    {
        $em = $this->getDoctrine()->getManager();
        $res = $em->getRepository('CPASimUSanteItemSelectorBundle:MainConfigItem')
            ->findOneByWorkspace($workspace);
        //Default configuration
        if (null == $res) {
            $defaultResourceType = $em->getRepository('ClarolineCoreBundle:Resource\ResourceType')
                ->findOneByName('file');
            $config = [
                'itemCount' => 3,
                'namePattern' => '',
                'resourceType' => $defaultResourceType->getId(),
                'mainResourceType' => 'file',
            ];
        } else {
            $id = $res->getMainResourceType()->getId();
            $mainResourceType = $em->getRepository('ClarolineCoreBundle:Resource\ResourceType')
                ->findOneById($id);
            $config = [
                'itemCount' => $res->getItemCount(),
                'namePattern' => $res->getNamePattern(),
                'resourceType' => $res->getResourceType()->getId(),
                'mainResourceType' => $mainResourceType->getName(),
            ];
        }

        return $config;
    }
}
