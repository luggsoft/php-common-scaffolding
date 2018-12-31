<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions;

final class CreateDirectoryHandlerDelegateProvider extends HandlerDelegateProviderBase
{

    /**
     * 
     * {@inheritdoc}
     */
    public function canHandle(InstructionInterface $instruction): bool
    {
        return $instruction instanceof CreateDirectoryInstruction;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getHandlerDelegate(): callable
    {
        return function (CreateDirectoryInstruction $instruction) {
            $message = vsprintf('Creating directory "%s", permissions = %03o', [
                $instruction->getPath(),
                $instruction->getPermissions(),
            ]);
            var_dump($message);
        };
    }

}
