<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

use Exception;

abstract class InstructionProcessorBase implements InstructionProcessorInterface
{

    /**
     * 
     * @param iterable|InstructionInterface[] $instructions
     * @param InstructionProcessorContext $instructionProcessorContext
     * @return void
     * @throws Exception
     */
    final public function processInstructions(iterable $instructions, InstructionProcessorContext $instructionProcessorContext = null): void
    {
        if ($instructionProcessorContext === null) {
            $instructionProcessorContext = new InstructionProcessorContext();
        }

        foreach ($instructions as $instruction) {
            if ($this->processInstruction($instruction, $instructionProcessorContext)) {
                continue;
            }

            throw new Exception('Unhandled instruction');
        }
    }

    /**
     * 
     * @param InstructionInterface $instruction
     * @param InstructionProcessorContext $processorContext
     * @return void
     */
    abstract public function processInstruction(InstructionInterface $instruction, InstructionProcessorContext $processorContext = null): bool;

}
