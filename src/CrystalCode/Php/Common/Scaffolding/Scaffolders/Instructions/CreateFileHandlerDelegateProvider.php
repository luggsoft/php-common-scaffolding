<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions;

final class CreateFileHandlerDelegateProvider extends HandlerDelegateProviderBase
{

    /**
     * 
     * {@inheritdoc}
     */
    public function canHandle(InstructionInterface $instruction): bool
    {
        return $instruction instanceof CreateFileInstruction;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getHandlerDelegate(): callable
    {
        return function (CreateFileInstruction $instruction) {
            $message = vsprintf('Creating file "%s", permissions = %03o, contents = "%s"', [
                $instruction->getPath(),
                $instruction->getPermissions(),
                $instruction->getContents(),
            ]);
            var_dump($message);
        };
    }

}
