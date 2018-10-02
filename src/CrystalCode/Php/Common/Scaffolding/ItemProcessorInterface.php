<?php

namespace CrystalCode\Php\Common\Scaffolding;

interface ItemProcessorInterface
{

    /**
     * 
     * @param ItemInterface $item
     * @return InstructionInterface[]
     */
    function processItem(ItemInterface $item);

}
