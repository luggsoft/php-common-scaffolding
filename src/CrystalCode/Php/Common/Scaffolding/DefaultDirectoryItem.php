<?php

namespace CrystalCode\Php\Common\Scaffolding;

final class DefaultDirectoryItem extends DirectoryItemBase
{

    /**
     * 
     * @param string $name
     * @param ItemInterface[] $childItems
     */
    public function __construct($name, $childItems = [])
    {
        parent::__construct($name, $childItems);
    }

}
