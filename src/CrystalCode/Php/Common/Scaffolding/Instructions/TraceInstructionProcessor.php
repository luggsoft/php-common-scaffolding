<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

use CrystalCode\Php\Common\Injectors\InjectorInterface;

final class TraceInstructionProcessor extends InstructionProcessorBase
{

    /**
     * 
     * @param InjectorInterface $injector
     * @param callable[] $handlers
     */
    public function __construct(InjectorInterface $injector, $handlers = [])
    {
        parent::__construct($injector, [
            CreateFileInstruction::class => [$this, 'handleCreateFileInstruction'],
            CreateDirectoryInstruction::class => [$this, 'handleCreateDirectoryInstruction'],
        ]);
        $this->addInstructionHandlers($handlers);
    }

    /**
     * 
     * @param CreateFileInstruction $createFileInstruction
     * @return bool
     */
    public function handleCreateFileInstruction(CreateFileInstruction $createFileInstruction)
    {
        var_dump($createFileInstruction);
        return true;
    }

    /**
     * 
     * @param CreateDirectoryInstruction $createDirectoryInstruction
     * @return bool
     */
    public function handleCreateDirectoryInstruction(CreateDirectoryInstruction $createDirectoryInstruction)
    {
        var_dump($createDirectoryInstruction);
        return true;
    }

}
