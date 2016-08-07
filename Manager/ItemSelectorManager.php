<?php

namespace CPASimUSante\ItemSelectorBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use CPASimUSante\ItemSelectorBundle\Exception\NoMainConfigException;
use CPASimUSante\ItemSelectorBundle\Entity\MainConfig;
use Doctrine\ORM\EntityManager;

/**
 * @DI\Service("cpasimusante_itemselector.manager.plugin.itemselector")
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
}
