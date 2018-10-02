<?php

namespace CrystalCode\Php\Common\Scaffolding;

use CrystalCode\Php\Common\Collections\Collection;

abstract class DirectoryItemBase extends ItemBase
{

    /**
     *
     * @var array|ItemInterface[]
     */
    private $childItems = [];

    /**
     * 
     * @param string $name
     * @param ItemInterface[] $childItems
     */
    public function __construct($name, $childItems = [])
    {
        parent::__construct($name);
        $this->addChildItems($childItems);
    }

    /**
     * 
     * @return array|ItemInterface[]
     */
    final public function getChildItems()
    {
        return $this->childItems;
    }

    /**
     * 
     * @param ItemInterface[] $childItems
     */
    final public function addChildItems($childItems)
    {
        foreach (Collection::create($childItems) as $childItem) {
            $this->addChildItem($childItem);
        }
    }

    /**
     * 
     * @param ItemInterface $childItem
     * @return void
     */
    final public function addChildItem(ItemInterface $childItem)
    {
        $this->childItems[] = $childItem;
        if ($childItem instanceof ItemBase) {
            $childItem->setParentItem($this);
        }
    }

}
