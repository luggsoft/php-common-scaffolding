<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

final class RemoveDirectoryInstructionHandlerDelegateProvider extends InstructionHandlerDelegateProviderBase
{

    /**
     * 
     * {@inheritdoc}
     */
    public function canHandle(InstructionInterface $instruction): bool
    {
        return $instruction instanceof RemoveDirectoryInstruction;
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
