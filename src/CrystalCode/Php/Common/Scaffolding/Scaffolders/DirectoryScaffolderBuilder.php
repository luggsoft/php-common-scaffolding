<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders;

use CrystalCode\Php\Common\ArgumentException;

final class DirectoryScaffolderBuilder extends ScaffolderBuilderBase
{

    /**
     * 
     * @param mixed $scaffolders
     * @return ScaffolderProviderInterface
     * @throws ArgumentException
     */
    public static function normalizeScaffolders($scaffolders): ScaffolderProviderInterface
    {
        if ($scaffolders instanceof ScaffoldersProviderInterface) {
            return $scaffolders;
        }

        if (is_callable($scaffolders)) {
            return new DelegateScaffoldersProvider($scaffolders);
        }

        if (is_array($scaffolders)) {
            return new DelegateScaffoldersProvider(function () use ($scaffolders) {
                foreach ($scaffolders as $scaffolder) {
                    yield $scaffolder;
                }
            });
        }

        throw new ArgumentException('scaffolders');
    }

    /**
     * 
     * @return DirectoryScaffolderBuilder
     */
    public static function create(): DirectoryScaffolderBuilder
    {
        return (new DirectoryScaffolderBuilder)
            ->withPath('')
            ->withPermissions(0777)
            ->withScaffolders([]);
    }

    /**
     *
     * @var PathProviderInterface
     */
    private $pathProvider;

    /**
     *
     * @var PermissionsProviderInterface
     */
    private $permissionsProvider;

    /**
     *
     * @var ScaffolderProviderInterface
     */
    private $scaffoldersProvider;

    /**
     * 
     * @param mixed $path
     * @return DirectoryScaffolderBuilder
     * @throws ArgumentException
     */
    public function withPath($path): DirectoryScaffolderBuilder
    {
        $this->pathProvider = self::normalizePath($path);
        return $this;
    }

    /**
     * 
     * @param mixed $permissions
     * @return DirectoryScaffolderBuilder
     * @throws ArgumentException
     */
    public function withPermissions($permissions): DirectoryScaffolderBuilder
    {
        $this->permissionsProvider = self::normalizePermissions($permissions);
        return $this;
    }

    /**
     * 
     * @param mixed $scaffolders
     * @return DirectoryScaffolderBuilder
     */
    public function withScaffolders($scaffolders): DirectoryScaffolderBuilder
    {
        $this->scaffoldersProvider = self::normalizeScaffolders($scaffolders);
        return $this;
    }

    /**
     * 
     * @return DirectoryScaffolder
     */
    public function build(): DirectoryScaffolder
    {
        return new DirectoryScaffolder($this->pathProvider, $this->permissionsProvider, $this->scaffoldersProvider);
    }

}
