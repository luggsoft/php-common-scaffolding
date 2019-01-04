<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

final class DebugInstructionHandlerDelegateProvider extends InstructionHandlerDelegateProviderBase
{

    /**
     * 
     * {@inheritdoc}
     */
    public function canHandle(InstructionInterface $instruction): bool
    {
        return true;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getHandlerDelegate(): callable
    {
        return function (InstructionInterface $instruction) {
            if ($instruction instanceof CreateFileInstruction) {
                echo vsprintf('F %04o @ "%s" => %s' . PHP_EOL, [
                    $instruction->getPermissions(),
                    $instruction->getPath(),
                    trim($instruction->getContents()),
                ]);
            }

            if ($instruction instanceof CreateDirectoryInstruction) {
                echo vsprintf('D %04o @ "%s"' . PHP_EOL, [
                    $instruction->getPermissions(),
                    $instruction->getPath(),
                ]);
            }
        };
    }

}
