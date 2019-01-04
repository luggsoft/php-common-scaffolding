<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

interface InstructionProcessorInterface
{

    /**
     * 
     * @param iterable|InstructionInterface[] $instructions
     * @param InstructionProcessorContext $instructionProcessorContext
     * @return void
     */
    function processInstructions(iterable $instructions, InstructionProcessorContext $instructionProcessorContext = null): void;

}
