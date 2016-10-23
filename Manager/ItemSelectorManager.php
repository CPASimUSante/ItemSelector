<?php

namespace CPASimUSante\ItemSelectorBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use CPASimUSante\ItemSelectorBundle\Entity\ItemSelector;
use CPASimUSante\ItemSelectorBundle\Exception\NoMainConfigException;
use CPASimUSante\ItemSelectorBundle\Entity\MainConfig;
use Doctrine\ORM\EntityManager;

/**
 * @DI\Service("cpasimusante_itemselector.manager.itemselector")
 */
class ItemSelectorManager
{
    private $em;

    /**
     * @DI\InjectParams({
     *     "em" = @DI\Inject("doctrine.orm.entity_manager")
     * })
     *
     * @param ObjectManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getMainConfig()
    {
        try {
            $mainConfig = $this->em->getRepository('CPASimUSanteItemSelectorBundle:MainConfig')
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

    public function getItems(ItemSelector $itemSelector)
    {
        $itemSelectorData = [];

        $itemsSelectorRaw = $this->em
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
            $itemsRawData = $this->em->getRepository('CPASimUSanteItemSelectorBundle:Item')
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
        $rep = $this->em->getRepository('ClarolineCoreBundle:Resource\ResourceNode');
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

    public function saveItemSelector(ItemSelector $itemSelector, $mainItem, $itemSelectorData)
    {
        $this->em->startFlushSuite();
        //$simupoll->setDescription($description);
        $this->em->persist($itemSelector);
        //First remove old
        $items = $this->em->getRepository('CPASimUSanteItemSelectorBundle:Item')
            ->findByItemselector($itemSelector);
        foreach ($items as $itemToDelete) {
            $this->em->remove($itemToDelete);
        }
        //then add new
        foreach ($itemSelectorData as $item) {
            //add Item
            $newItem = new Item();
            $newItem->setResourceNode($item);
            $newItem->setItemselector($itemSelector);
            $this->em->persist($newItem);
        }
        $this->em->endFlushSuite();
    }
}
