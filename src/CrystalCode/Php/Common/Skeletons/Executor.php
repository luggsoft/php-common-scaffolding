<?php

namespace CrystalCode\Php\Common\Skeletons;

use CrystalCode\Php\Common\Scaffolding\ExecutorBase;
use CrystalCode\Php\Common\Scaffolding\Instructions\DebugInstructionHandlerDelegateProvider;
use CrystalCode\Php\Common\Scaffolding\Instructions\InstructionProcessor;
use CrystalCode\Php\Common\Scaffolding\Instructions\InstructionProcessorInterface;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\DelegateScaffolderProvider;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\DirectoryScaffolderBuilder;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\FileScaffolderBuilder;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\ScaffolderProviderInterface;
use CrystalCode\Php\Common\Skeletons\Templates\TestTemplate;

final class Executor extends ExecutorBase
{

    /**
     *
     * @var string
     */
    private $targetPath;

    /**
     *
     * @var string
     */
    private $sourcePath;

    /**
     *
     * @var string
     */
    private $sourceNamespaceName;

    /**
     * 
     * @param string $targetPath
     * @param string $sourcePath
     * @param string $sourceNamespaceName
     */
    public function __construct(string $targetPath, string $sourcePath, string $sourceNamespaceName)
    {
        $this->targetPath = $targetPath;
        $this->sourcePath = $sourcePath;
        $this->sourceNamespaceName = $sourceNamespaceName;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getRootPath(): string
    {
        return $this->targetPath;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getScaffolderProvider(): ScaffolderProviderInterface
    {
        return new DelegateScaffolderProvider(function () {
            foreach ($this->getClassReflectionProvider()->getClassReflections() as $classReflection) {
                $namespaceName = $classReflection->getNamespaceName();
                $path = strtr($namespaceName, '\\', '/');

                yield DirectoryScaffolderBuilder::create()
                    ->withPath($path)
                    ->withScaffolders(function () use ($classReflection) {
                        $name = $classReflection->getShortName();
                        $path = sprintf('%sTest.php', $name);
                        $template = new TestTemplate($classReflection);

                        yield FileScaffolderBuilder::create()
                          ->withPath($path)
                          ->withContents($template)
                          ->build();
                    })
                    ->build();
            }
        });
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getInstructionProcessor(): InstructionProcessorInterface
    {
        return new InstructionProcessor(...[
            new DebugInstructionHandlerDelegateProvider(),
        ]);
    }

    /**
     * 
     * @return ClassReflectionProviderInterface
     */
    private function getClassReflectionProvider(): ClassReflectionProviderInterface
    {
        return new ClassReflectionProvider($this->sourcePath, $this->sourceNamespaceName);
    }

}
