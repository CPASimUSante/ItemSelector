<?php

namespace CPASimUSante\ItemSelectorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MainConfig.
 *
 * @ORM\Table(name="cpasimusante__mainconfig")
 * @ORM\Entity(repositoryClass="CPASimUSante\ItemSelectorBundle\Repository\MainConfigRepository")
 */
class MainConfig
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
     * @var Items[]
     *
     * @ORM\OneToMany(targetEntity="CPASimUSante\ItemSelectorBundle\Entity\MainConfigItem", mappedBy="mainconfig", cascade={"all"})
     */
    protected $items;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

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
     * Add item.
     *
     * @param \CPASimUSante\ItemSelectorBundle\Entity\MainConfigItem $item
     *
     * @return Mainconfig
     */
    public function addItem(\CPASimUSante\ItemSelectorBundle\Entity\MainConfigItem $item)
    {
        /*       $this->items[] = $item;
               //$item->setItemselector($this);
               return $this;
       */
        $item->setMainconfig($this);

        $this->items->add($item);
    }

    /**
     * Remove item.
     *
     * @param \CPASimUSante\ItemSelectorBundle\Entity\MainConfigItem $item
     */
    public function removeItem(\CPASimUSante\ItemSelectorBundle\Entity\MainConfigItem $item)
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
}
