<?php

namespace CPASimUSante\ItemSelectorBundle\Controller;

use CPASimUSante\ItemSelectorBundle\Entity\Item;
use CPASimUSante\ItemSelectorBundle\Entity\ItemSelector;
use CPASimUSante\ItemSelectorBundle\Form\ItemSelectorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

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
        $em = $this->getDoctrine()->getManager();

        // Create an ArrayCollection of the current Item objects in the database
        $originalItems = new ArrayCollection();
        foreach ($itemSelector->getItems() as $item) {
            $originalItems->add($item);
        }

        //retrieve ItemSelector configuration for this WS
        $config = $this->getConfig($itemSelector->getResourceNode()->getWorkspace()->getId());

        $mainResourceType = $config['mainResourceType'];
        $resourceType = $config['resourceType'];
        $namePattern = $config['namePattern'];
        $form = $this->get('form.factory')
            ->create(new ItemSelectorType($mainResourceType, $resourceType, $namePattern), $itemSelector);
        $form->handleRequest($request);

        if ($form->isValid()) {
            // remove the relationship between the item and the ItemSelector
            foreach ($originalItems as $item) {
                if (false === $itemSelector->getItems()->contains($item)) {
                    // in a a many-to-one relationship, remove the relationship
                    $item->setItemSelector(null);
                    $em->persist($item);
                    // to delete the Item entirely, you can also do that
                    $em->remove($item);
                }
            }

            $em->persist($itemSelector);
            $em->flush();
        }

        return [
            '_resource' => $itemSelector,
            'form' => $form->createView(),
            'itemCount' => $config['itemCount'],
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
