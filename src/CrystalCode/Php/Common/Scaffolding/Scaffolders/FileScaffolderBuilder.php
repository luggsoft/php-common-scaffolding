<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders;

use CrystalCode\Php\Common\ArgumentException;
use CrystalCode\Php\Common\Scaffolding\Templates\DelegateTemplateProvider;
use CrystalCode\Php\Common\Scaffolding\Templates\TemplateProviderInterface;
use CrystalCode\Php\Common\Templates\TemplateInterface;

final class FileScaffolderBuilder extends ScaffolderBuilderBase
{

    /**
     * 
     * @param mixed $contents
     * @param mixed $values
     * @return ContentsProviderInterface
     * @throws ArgumentException
     */
    public static function normalizeContents($contents, $values = []): ContentsProviderInterface
    {
        if ($contents instanceof ContentsProviderInterface) {
            return $contents;
        }

        if ($contents instanceof TemplateProviderInterface) {
            return new TemplateContentsProvider($contents, $values);
        }

        if ($contents instanceof TemplateInterface) {
            $templateProvider = new DelegateTemplateProvider(null, function () use ($contents) {
                return $contents;
            });

            return new TemplateContentsProvider($templateProvider, $values);
        }

        if (is_callable($contents)) {
            return new DelegateContentsProvider($contents);
        }

        if (is_string($contents)) {
            return new DelegateContentsProvider(function () use ($contents) {
                return $contents;
            });
        }

        throw new ArgumentException('contents');
    }

    /**
     * 
     * @return FileScaffolderBuilder
     */
    public static function create(): FileScaffolderBuilder
    {
        return (new FileScaffolderBuilder)
            ->withPath('')
            ->withContents('')
            ->withPermissions(0777);
    }

    /**
     *
     * @var PathProviderInterface
     */
    private $pathProvider;

    /**
     *
     * @var ContentsProviderInterface
     */
    private $contentsProvider;

    /**
     *
     * @var PermissionsProviderInterface
     */
    private $permissionsProvider;

    /**
     * 
     * @param mixed $path
     * @return FileScaffolderBuilder
     * @throws ArgumentException
     */
    public function withPath($path): FileScaffolderBuilder
    {
        $this->pathProvider = self::normalizePath($path);
        return $this;
    }

    /**
     * 
     * @param mixed $contents
     * @param mixed $values
     * @return FileScaffolderBuilder
     * @throws ArgumentException
     */
    public function withContents($contents, $values = []): FileScaffolderBuilder
    {
        $this->contentsProvider = self::normalizeContents($contents, $values);
        return $this;
    }

    /**
     * 
     * @param mixed $permissions
     * @return FileScaffolderBuilder
     * @throws ArgumentException
     */
    public function withPermissions($permissions): FileScaffolderBuilder
    {
        $this->permissionsProvider = self::normalizePermissions($permissions);
        return $this;
    }

    /**
     * 
     * @return FileScaffolder
     */
    public function build(): FileScaffolder
    {
        return new FileScaffolder($this->pathProvider, $this->contentsProvider, $this->permissionsProvider);
    }

}
