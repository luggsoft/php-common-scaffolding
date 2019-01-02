<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders;

use CrystalCode\Php\Common\ArgumentException;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions\CreateDirectoryInstruction;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions\CreateFileInstruction;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions\InstructionInterface;

final class Processor
{

    /**
     * 
     * @param ScaffoldersProviderInterface $scaffoldersProvider
     * @param ProcessorContext $processorContext
     * @return iterable|InstructionInterface[]
     */
    public function processScaffoldersProvider(ScaffoldersProviderInterface $scaffoldersProvider, ProcessorContext $processorContext = null): iterable
    {
        if ($processorContext === null) {
            $processorContext = new ProcessorContext();
        }

        foreach ($scaffoldersProvider->getScaffolders() as $scaffolder) {
            yield from $this->processScaffolder($scaffolder, $processorContext);
        }
    }

    /**
     * 
     * @param ScaffolderInterface $scaffolder
     * @param ProcessorContext $processorContext
     * @return iterable|InstructionInterface[]
     * @throws ArgumentException
     */
    public function processScaffolder(ScaffolderInterface $scaffolder, ProcessorContext $processorContext = null): iterable
    {
        if ($processorContext === null) {
            $processorContext = new ProcessorContext();
        }

        if ($scaffolder instanceof FileScaffolder) {
            return yield from $this->processFileScaffolder($scaffolder, $processorContext);
        }

        if ($scaffolder instanceof DirectoryScaffolder) {
            return yield from $this->processDirectoryScaffolder($scaffolder, $processorContext);
        }

        throw new ArgumentException('scaffolder');
    }

    /**
     * 
     * @param FileScaffolder $fileScaffolder
     * @param ProcessorContext $processorContext
     * @return iterable|InstructionInterface[]
     */
    public function processFileScaffolder(FileScaffolder $fileScaffolder, ProcessorContext $processorContext = null): iterable
    {
        if ($processorContext === null) {
            $processorContext = new ProcessorContext();
        }

        $path = vsprintf('%s/%s', [
            trim($processorContext->getValue('path'), '/'),
            trim($fileScaffolder->getPathProvider()->getPath(), '/'),
        ]);

        $contents = $fileScaffolder->getContentsProvider()->getContents();
        $permissions = $fileScaffolder->getPermissionsProvider()->getPermissions();
        yield new CreateFileInstruction($path, $contents, $permissions);
    }

    /**
     * 
     * @param DirectoryScaffolder $directoryScaffolder
     * @param ProcessorContext $processorContext
     * @return iterable|InstructionInterface[]
     */
    public function processDirectoryScaffolder(DirectoryScaffolder $directoryScaffolder, ProcessorContext $processorContext = null): iterable
    {
        if ($processorContext === null) {
            $processorContext = new ProcessorContext();
        }

        $path = vsprintf('%s/%s', [
            trim($processorContext->getValue('path'), '/'),
            trim($directoryScaffolder->getPathProvider()->getPath(), '/'),
        ]);

        $permissions = $directoryScaffolder->getPermissionsProvider()->getPermissions();
        yield new CreateDirectoryInstruction($path, $permissions);

        foreach ($directoryScaffolder->getScaffoldersProvider()->getScaffolders() as $scaffolder) {
            $processorContext = $processorContext->withValue('path', $path);
            yield from $this->processScaffolder($scaffolder, $processorContext);
        }
    }

}
