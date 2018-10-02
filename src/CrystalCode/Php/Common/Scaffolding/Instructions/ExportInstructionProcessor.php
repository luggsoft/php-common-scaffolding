<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

use CrystalCode\Php\Common\Injectors\InjectorInterface;

final class ExportInstructionProcessor extends InstructionProcessorBase
{

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
        $path = $createFileInstruction->getPath();
        $data = $createFileInstruction->getData();
        $line = vsprintf('New-Item -Force -Path "%s" -ItemType File -Value @"%s"@;', [
            $this->escapePowerShellString(trim($path)),
            $this->escapePowerShellString(trim($data)) . PHP_EOL,
        ]);
        $this->writeLine($line);
        return true;
    }

    /**
     * 
     * @param CreateDirectoryInstruction $createDirectoryInstruction
     * @return bool
     */
    public function handleCreateDirectoryInstruction(CreateDirectoryInstruction $createDirectoryInstruction)
    {
        $path = $createDirectoryInstruction->getPath();
        $line = vsprintf('New-Item -Force -Path "%s" -ItemType Directory;', [
            $this->escapePowerShellString(trim($path)),
        ]);
        $this->writeLine($line);
        return true;
    }

    /**
     * 
     * @param string $string
     * @return string
     */
    private function escapePowerShellString($string)
    {
        return str_replace('$', '`$', $string);
    }

    /**
     * 
     * @param string $string
     * @return void
     */
    private function writeLine($string)
    {
        echo $string . PHP_EOL;
    }

}
