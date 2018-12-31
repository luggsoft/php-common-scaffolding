<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions;

interface ProcessorInterface
{

    /**
     * 
     * @param iterable|InstructionInterface[] $instructions
     * @param ProcessorContext $processorContext
     * @return void
     */
    function processInstructions(iterable $instructions, ProcessorContext $processorContext = null): void;

}
