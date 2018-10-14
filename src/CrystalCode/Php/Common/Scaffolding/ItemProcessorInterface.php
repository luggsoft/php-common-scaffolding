<?php

namespace CrystalCode\Php\Common\Scaffolding;

use CrystalCode\Php\Common\Scaffolding\Instructions\InstructionInterface;

interface ItemProcessorInterface
{

    /**
     * 
     * @param ItemInterface $item
     * @return InstructionInterface[]
     */
    function processItem(ItemInterface $item);

}
