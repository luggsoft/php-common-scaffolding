<?php

namespace CrystalCode\Php\Common\Cruddy;

final class Entity extends EntityBase
{

    /**
     * 
     * @param string $name
     * @param iterable|Property[] $properties
     */
    public function __construct(string $name, Property ...$properties)
    {
        parent::__construct($name, ...$properties);
    }

}
