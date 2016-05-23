<?php

namespace CPASimUSante\ItemSelectorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Item.
 *
 * @ORM\Table(name="cpasimusante__item")
 * @ORM\Entity(repositoryClass="CPASimUSante\ItemSelectorBundle\Repository\ItemRepository")
 */
class Item
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Claroline\CoreBundle\Entity\Resource\ResourceNode")
     * @ORM\JoinColumn(name="resource_node_id", referencedColumnName="id")
     */
    protected $resourceNode;

    /**
     * @var ItemSelector
     *
     * @ORM\ManyToOne(targetEntity="CPASimUSante\ItemSelectorBundle\Entity\ItemSelector", inversedBy="items")
     * @ORM\JoinColumn(name="itemselector_id", referencedColumnName="id")
     */
    protected $itemselector;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set itemcode.
     *
     * @param string $itemcode
     *
     * @return Item
     */
    public function setResourceNode($resourceNode)
    {
        $this->resourceNode = $resourceNode;

        return $this;
    }

    /**
     * Get itemcode.
     *
     * @return string
     */
    public function getResourceNode()
    {
        return $this->resourceNode;
    }

    /**
     * Set itemselector.
     *
     * @param \CPASimUSante\ItemSelectorBundle\Entity\ItemSelector $itemselector
     *
     * @return Item
     */
    public function setItemselector(\CPASimUSante\ItemSelectorBundle\Entity\ItemSelector $itemselector = null)
    {
        $this->itemselector = $itemselector;

        return $this;
    }

    /**
     * Get itemselector.
     *
     * @return \CPASimUSante\ItemSelectorBundle\Entity\ItemSelector
     */
    public function getItemselector()
    {
        return $this->itemselector;
    }
}
