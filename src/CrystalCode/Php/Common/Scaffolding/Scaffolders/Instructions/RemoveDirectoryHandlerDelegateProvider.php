<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions;

final class RemoveDirectoryHandlerDelegateProvider extends HandlerDelegateProviderBase
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
