<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

final class CreateDirectoryInstructionHandlerDelegateProvider extends InstructionHandlerDelegateProviderBase
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
            $path = $instruction->getPath();

            if (is_dir($path)) {
                return;
            }

            $permissions = $instruction->getPermissions();
            mkdir($path, $permissions, true);
        };
    }

}
