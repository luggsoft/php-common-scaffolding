<?php

namespace CrystalCode\Php\Common\Scaffolding;

use CrystalCode\Php\Common\Collections\Collection;

abstract class ItemBase implements ItemInterface
{

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var ItemInterface
     */
    private $parentItem;

    /**
     *
     * @var array
     */
    private $values = [];

    /**
     * 
     * @param string $name
     * @param mixed $values
     */
    public function __construct($name, $values = [])
    {
        $this->name = (string) $name;
        $this->setValues($values);
    }

    /**
     * 
     * @return string
     */
    final public function getName()
    {
        return $this->name;
    }

    /**
     * 
     * @return bool
     */
    final public function hasParentItem()
    {
        return $this->parentItem instanceof ItemInterface;
    }

    /**
     * 
     * @return ItemInterface
     */
    final public function getParentItem()
    {
        return $this->parentItem;
    }

    /**
     * 
     * @param bool $includeSelf
     * @return array|ItemInterface[]
     */
    final public function getAncestorItems($includeSelf = true)
    {
        $ancestorItems = [];
        if ($this->hasParentItem()) {
            $parentItem = $this->getParentItem();
            $ancestorItems = $parentItem->getAncestorItems(true);
        }
        if ($includeSelf) {
            return array_merge($ancestorItems, [$this]);
        }
        return $ancestorItems;
    }

    /**
     * 
     * @param string $name
     */
    final protected function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * 
     * @param ItemInterface $parentItem
     * @return void
     */
    final protected function setParentItem(ItemInterface $parentItem)
    {
        $this->parentItem = $parentItem;
    }

    /**
     * 
     * @param mixed $values
     * @return ItemInterface
     */
    final public function withValues($values)
    {
        $clone = clone $this;
        $clone->setValues($values);
        return $clone;
    }

    /**
     * 
     * @param string $name
     * @param mixed $value
     * @return ItemInterface
     */
    final public function withValue($name, $value)
    {
        $clone = clone $this;
        $clone->setValue($name, $value);
        return $clone;
    }

    /**
     * 
     * @param mixed $values
     * @return void
     */
    private function setValues($values)
    {
        foreach (Collection::create($values) as $name => $value) {
            $this->setValue($name, $value);
        }
    }

    /**
     * 
     * @param string $name
     * @param mixed $value
     * @return void
     */
    private function setValue($name, $value)
    {
        $this->values[(string) $name] = $value;
    }

}
