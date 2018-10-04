<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

interface InstructionProcessorInterface
{

    /**
     * 
     * @param InstructionInterface $instruction
     * @return bool
     */
    function processInstruction(InstructionInterface $instruction);

}
