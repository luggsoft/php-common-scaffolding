<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions;

final class RemoveFileHandlerDelegateProvider extends HandlerDelegateProviderBase
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
