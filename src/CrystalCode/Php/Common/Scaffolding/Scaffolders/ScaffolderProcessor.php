<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders;

use CrystalCode\Php\Common\ArgumentException;
use CrystalCode\Php\Common\Scaffolding\Instructions\CreateDirectoryInstruction;
use CrystalCode\Php\Common\Scaffolding\Instructions\CreateFileInstruction;
use CrystalCode\Php\Common\Scaffolding\Instructions\InstructionInterface;

final class ScaffolderProcessor
{

    /**
     * 
     * @param ScaffolderProviderInterface $scaffolderProvider
     * @param ScaffolderProcessorContext $processorContext
     * @return iterable|InstructionInterface[]
     */
    public function processScaffolderProvider(ScaffolderProviderInterface $scaffolderProvider, ScaffolderProcessorContext $processorContext = null): iterable
    {
        if ($processorContext === null) {
            $processorContext = new ScaffolderProcessorContext();
        }

        foreach ($scaffolderProvider->getScaffolders() as $scaffolder) {
            yield from $this->processScaffolder($scaffolder, $processorContext);
        }
    }

    /**
     * 
     * @param ScaffolderInterface $scaffolder
     * @param ScaffolderProcessorContext $processorContext
     * @return iterable|InstructionInterface[]
     * @throws ArgumentException
     */
    public function processScaffolder(ScaffolderInterface $scaffolder, ScaffolderProcessorContext $processorContext = null): iterable
    {
        if ($processorContext === null) {
            $processorContext = new ScaffolderProcessorContext();
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
     * @param ScaffolderProcessorContext $processorContext
     * @return iterable|InstructionInterface[]
     */
    public function processFileScaffolder(FileScaffolder $fileScaffolder, ScaffolderProcessorContext $processorContext = null): iterable
    {
        if ($processorContext === null) {
            $processorContext = new ScaffolderProcessorContext();
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
     * @param ScaffolderProcessorContext $processorContext
     * @return iterable|InstructionInterface[]
     */
    public function processDirectoryScaffolder(DirectoryScaffolder $directoryScaffolder, ScaffolderProcessorContext $processorContext = null): iterable
    {
        if ($processorContext === null) {
            $processorContext = new ScaffolderProcessorContext();
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
