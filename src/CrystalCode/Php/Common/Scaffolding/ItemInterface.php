<?php

namespace CrystalCode\Php\Common\Scaffolding;

interface ItemInterface
{

    /**
     * 
     * @return string
     */
    function getName();

    /**
     * 
     * @return bool
     */
    function hasParentItem();

    /**
     * 
     * @return ItemInterface
     */
    function getParentItem();

    /**
     * 
     * @param bool $includeSelf
     * @return array|ItemInterface[]
     */
    function getAncestorItems($includeSelf = true);

    /**
     * 
     * @param mixed $values
     * @return ItemInterface
     */
    function withValues($values);

    /**
     * 
     * @param string $name
     * @param mixed $value
     * @return ItemInterface
     */
    function withValue($name, $value);

}
