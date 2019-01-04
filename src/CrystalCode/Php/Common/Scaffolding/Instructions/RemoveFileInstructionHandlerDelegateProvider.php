<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

final class RemoveFileInstructionHandlerDelegateProvider extends InstructionHandlerDelegateProviderBase
{

    /**
     * 
     * {@inheritdoc}
     */
    public function canHandle(InstructionInterface $instruction): bool
    {
        return $instruction instanceof RemoveFileInstruction;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getHandlerDelegate(): callable
    {
        return function () {
            
        };
    }

}
