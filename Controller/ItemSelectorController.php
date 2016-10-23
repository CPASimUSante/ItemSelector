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

        $itemData = $this->itemSelectorManager->getItems($itemSelector);
        $mainResource = isset($itemData['main']) ? $itemData['main'] : [];
        $itemResourceTypeName = $this->itemSelectorManager->getResourceType($resourceType);
        $items = isset($itemData['items']) ? $itemData['items'] : [];
        //retrieve the list of items to be displayed in the item select
        $itemlist = $this->itemSelectorManager->getAuthorizedItemList($resourceType, $namePattern, 'name');

        return [
            'mainResourceType' => $mainResourceType,
            '_resource' => $itemSelector,
            'itemSelectorMain' => $mainResource,
            'itemSelectorItems' => $items,
            'itemList' => $itemlist,
            'itemCountMax' => $config['itemCount'],
            'itemResourceTypeName' => $itemResourceTypeName,
            'id' => $itemSelector->getId(),
        ];
    }

    /**
     * Save the ItemSelector data.
     *
     * @EXT\Route("/save/{isid}", name="cpasimusante_itemselector_save", options={"expose"=true})
     * @EXT\ParamConverter("itemselector", class="CPASimUSanteItemSelectorBundle:ItemSelector", options={"mapping": {"isid" = "id"}})
     * @EXT\Method("POST")
     *
     * @return array
     */
     public function saveItemSelectorAction(Request $request, ItemSelector $itemselector)
     {
         $user = $this->container->get('security.token_storage')->getToken()->getUser();
         //$this->assertCanEdit($category->getResult());
         //retrive the data passed through the AJS CategoryService
         $mainResource = $request->request->get('mainResource');
         $itemSelectorData = $request->request->get('itemSelectorData');
         //create response
         $response = new JsonResponse();
         $error = array();
         //check for errors, server-side
         if ($mainResource === '') {
             $error[] = 'Main resource is empty';
         }
         foreach ($itemSelectorData as $data) {
             if (isset($data['propositions'])) {
                 foreach ($data['propositions'] as $proposition) {
                     if ($proposition['mark'] != ''
                         && $proposition['choice'] == '') {
                         $error[] = "Choice can't be null";
                     }
                 }
             }
         }
         if ($error !== []) {
             $response->setData('<ul><li>'.implode('</li><li>', $error).'</li></ul>');
             $response->setStatusCode(422);
         } else {
             $this->itemSelectorManager->saveItemSelector($itemselector, $mainResource, $itemSelectorData);
             $response->setStatusCode(200);
         }
         return $response;
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
