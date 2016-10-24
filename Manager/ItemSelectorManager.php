<?php

namespace CPASimUSante\ItemSelectorBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use CPASimUSante\ItemSelectorBundle\Entity\Item;
use CPASimUSante\ItemSelectorBundle\Entity\ItemSelector;
use CPASimUSante\ItemSelectorBundle\Exception\NoMainConfigException;
use CPASimUSante\ItemSelectorBundle\Entity\MainConfig;
use Claroline\CoreBundle\Persistence\ObjectManager;

/**
 * @DI\Service("cpasimusante_itemselector.manager.itemselector")
 */
class ItemSelectorManager
{
    private $om;

    /**
     * @DI\InjectParams({
     *     "om" = @DI\Inject("claroline.persistence.object_manager")
     * })
     *
     * @param ObjectManager $em
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function getMainConfig()
    {
        try {
            $mainConfig = $this->om->getRepository('CPASimUSanteItemSelectorBundle:MainConfig')
                ->findAll();
            if (sizeof($mainConfig) == 0) {
                throw new NoMainConfigException();
            } else {
                return $mainConfig[0];
            }
        } catch (NoMainConfigException $nme) {
            return new MainConfig();
        }
    }

    public function getResourceType($resourceType)
    {
        $itemResourceType = $this->om->getRepository('ClarolineCoreBundle:Resource\ResourceType')
            ->findOneById($resourceType);
        return isset($itemResourceType) ? $itemResourceType->getName() : '';
    }

    public function getItems(ItemSelector $itemSelector)
    {
        $itemSelectorData = [];

        $itemsSelectorRaw = $this->om
            ->getRepository('CPASimUSanteItemSelectorBundle:ItemSelector')
            ->findOneById($itemSelector->getId());
        if (isset($itemsSelectorRaw)) {
            //get ItemSelector main resource
            $rrn = $itemsSelectorRaw->getResource();
            if (isset($rrn)) {
                $itemSelectorData['main'] = [
                    'id' => $rrn->getId(),
                    'name' => $rrn->getName(),
                ];
            }

            //get ItemSelector items
            $itemsRawData = $this->om->getRepository('CPASimUSanteItemSelectorBundle:Item')
                ->findByItemselector($itemSelector);
            foreach ($itemsRawData as $item) {
                $rn = $item->getResourceNode();
                $itemSelectorData['items'][] = [
                    // 'id' => $item->getId(),
                    // 'resource' => [
                        'id' => $rn->getId(),
                        'name' => $rn->getName()
                    // ]
                ];
            }
        }

        return $itemSelectorData;
    }

    /**
     * Retrieve the resources filtered with the specified parameters.
     *
     * @return array
     */
    public function getAuthorizedItemList($resourceType, $namePattern, $orderedBy='name')
    {
        //repo of resourceNode
        $rep = $this->om->getRepository('ClarolineCoreBundle:Resource\ResourceNode');
        //get only the resource with the specified filters
        $qb = $rep->createQueryBuilder('rn')
            ->where('rn.resourceType = :resourcetype')
            ->setParameter('resourcetype', $resourceType);
        if ($namePattern !== '') {
            $qb->andWhere('rn.name LIKE :namePattern')
                ->setParameter('namePattern', $namePattern.'%');
        }
        $qb->orderBy('rn.'.$orderedBy, 'ASC');
        $query = $qb->getQuery();
        $itemsRaw = $query->getResult();

        $items = [];
        foreach($itemsRaw as $item)
        {
            $items[] = [
                'id' => $item->getId(),
                'name' => $item->getname(),
            ];
        }

        return $items;
    }

    /**
     * Save the itemSelector data.
     */
    public function saveItemSelector(ItemSelector $itemSelector, $mainResource, $itemSelectorData)
    {
        $this->om->startFlushSuite();
        $resource = null;
        if (isset($mainResource['id'])) {
            $resource = $this->om->getRepository('ClarolineCoreBundle:Resource\ResourceNode')
                ->findOneById($mainResource['id']);
        }

        $itemSelector->setResource($resource);
        $this->om->persist($itemSelector);

        //First remove old items
        $items = $this->om->getRepository('CPASimUSanteItemSelectorBundle:Item')
            ->findByItemselector($itemSelector);
        foreach ($items as $itemToDelete) {
            $this->om->remove($itemToDelete);
        }
        //then add new items
        foreach ($itemSelectorData as $itemData) {
            if (isset($itemData['id'])) {
                $newItem = new Item();
                $resource = $this->om->getRepository('ClarolineCoreBundle:Resource\ResourceNode')
                    ->findOneById($itemData['id']);
                $newItem->setResourceNode($resource);
                $newItem->setItemselector($itemSelector);
                $this->om->persist($newItem);
            }
        }
        $this->om->endFlushSuite();
    }
}
