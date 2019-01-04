<?php

namespace CrystalCode\Php\Common\Cruddy;

interface EntityInterface
{

    /**
     * 
     * @return string
     */
    function getName(): string;

    /**
     * 
     * @return iterable|Property[]
     */
    function getProperties(): iterable;

}
