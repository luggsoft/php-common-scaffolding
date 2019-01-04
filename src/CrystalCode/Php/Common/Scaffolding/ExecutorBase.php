<?php

namespace CrystalCode\Php\Common\Scaffolding;

use CrystalCode\Php\Common\Scaffolding\Instructions\InstructionProcessorContext;
use CrystalCode\Php\Common\Scaffolding\Instructions\InstructionProcessorInterface;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\ScaffolderProcessor;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\ScaffolderProcessorContext;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\ScaffolderProviderInterface;

abstract class ExecutorBase implements ExecutorInterface
{

    /**
     * 
     * @todo
     */
    final public function __construct()
    {
        // @TODO
    }

    /**
     * 
     * @return void
     */
    final public function execute(): void
    {
        $scaffoldersProvider = $this->getScaffolderProvider();
        $scaffolderProcessor = new ScaffolderProcessor();
        $scaffolderProcessorContext = new ScaffolderProcessorContext([
            'path' => $this->getRootPath(),
        ]);
        $instructions = $scaffolderProcessor->processScaffolderProvider($scaffoldersProvider, $scaffolderProcessorContext);
        $instructionProcessor = $this->getInstructionProcessor();
        $instructionProcessorContext = new InstructionProcessorContext();
        $instructionProcessor->processInstructions($instructions, $instructionProcessorContext);
    }

    /**
     * 
     * @return string
     */
    abstract public function getRootPath(): string;

    /**
     * 
     * @return ScaffolderProviderInterface
     */
    abstract public function getScaffolderProvider(): ScaffolderProviderInterface;

    /**
     * 
     * @return InstructionProcessorInterface
     */
    abstract public function getInstructionProcessor(): InstructionProcessorInterface;

}
