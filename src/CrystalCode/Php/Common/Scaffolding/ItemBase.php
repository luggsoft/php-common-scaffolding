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
     * {@inheritdoc}
     */
    final public function getName()
    {
        return $this->name;
    }

    /**
     * 
     * {@inheritdoc}
     */
    final public function hasParentItem()
    {
        return $this->parentItem instanceof ItemInterface;
    }

    /**
     * 
     * {@inheritdoc}
     */
    final public function getParentItem()
    {
        return $this->parentItem;
    }

    /**
     * 
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    final public function withValues($values)
    {
        $clone = clone $this;
        $clone->setValues($values);
        return $clone;
    }

    /**
     * 
     * {@inheritdoc}
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
