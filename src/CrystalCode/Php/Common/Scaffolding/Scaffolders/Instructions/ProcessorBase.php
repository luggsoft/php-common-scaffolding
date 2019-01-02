<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions;

use Exception;

abstract class ProcessorBase implements ProcessorInterface
{

    /**
     * 
     * @param iterable|InstructionInterface[] $instructions
     * @param ProcessorContext $processorContext
     * @return void
     * @throws Exception
     */
    final public function processInstructions(iterable $instructions, ProcessorContext $processorContext = null): void
    {
        if ($processorContext === null) {
            $processorContext = new ProcessorContext();
        }

        foreach ($instructions as $instruction) {
            if ($this->processInstruction($instruction, $processorContext)) {
                continue;
            }

            throw new Exception('Unhandled instruction');
        }
    }

    /**
     * 
     * @param InstructionInterface $instruction
     * @param ProcessorContext $processorContext
     * @return void
     */
    abstract public function processInstruction(InstructionInterface $instruction, ProcessorContext $processorContext = null): bool;

}
