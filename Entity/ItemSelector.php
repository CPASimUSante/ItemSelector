<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CPASimUSante\ItemSelectorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Claroline\CoreBundle\Entity\Resource\AbstractResource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="cpasimusante__itemselector")
 * @ORM\Entity(repositoryClass="CPASimUSante\ItemSelectorBundle\Repository\ItemSelectorRepository")
 */
class ItemSelector extends AbstractResource
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var Items[]
     *
     * @ORM\OneToMany(targetEntity="CPASimUSante\ItemSelectorBundle\Entity\Item", mappedBy="itemselector", cascade={"all"})
     */
    protected $items;

    /**
     * Wiki to select = Clinical case...
     *
     * @var \Icap\WikiBundle\Entity\Wiki
     * 
     * @ORM\ManyToOne(targetEntity="Claroline\CoreBundle\Entity\Resource\ResourceNode", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="SET NULL", nullable=true)
     */
    protected $resource;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * Add item.
     *
     * @param \CPASimUSante\ItemSelectorBundle\Entity\Item $item
     *
     * @return ItemSelector
     */
    public function addItem(\CPASimUSante\ItemSelectorBundle\Entity\Item $item)
    {
        /*       $this->items[] = $item;
        //$item->setItemselector($this);
        return $this;
*/
        $item->setItemselector($this);

        $this->items->add($item);
    }

    /**
     * Remove item.
     *
     * @param \CPASimUSante\ItemSelectorBundle\Entity\Item $item
     */
    public function removeItem(\CPASimUSante\ItemSelectorBundle\Entity\Item $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set resource.
     *
     * @param \Claroline\CoreBundle\Entity\Resource\ResourceNode $resource
     *
     * @return ItemSelector
     */
    public function setResource(\Claroline\CoreBundle\Entity\Resource\ResourceNode $resource = null)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource.
     *
     * @return \Claroline\CoreBundle\Entity\Resource\ResourceNode
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return ItemSelector
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
