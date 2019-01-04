<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders;

class DirectoryScaffolder extends ScaffolderBase
{

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
     * @param PathProviderInterface $pathProvider
     * @param PermissionsProviderInterface $permissionsProvider
     * @param ScaffolderProviderInterface $scaffoldersProvider
     */
    public function __construct(PathProviderInterface $pathProvider, PermissionsProviderInterface $permissionsProvider, ScaffolderProviderInterface $scaffoldersProvider = null)
    {
        $this->pathProvider = $pathProvider;
        $this->permissionsProvider = $permissionsProvider;
        $this->scaffoldersProvider = $scaffoldersProvider;
    }

    /**
     * 
     * @return PathProviderInterface
     */
    public function getPathProvider(): PathProviderInterface
    {
        return $this->pathProvider;
    }

    /**
     * 
     * @return PermissionsProviderInterface
     */
    public function getPermissionsProvider(): PermissionsProviderInterface
    {
        return $this->permissionsProvider;
    }

    /**
     * 
     * @return ScaffolderProviderInterface
     */
    public function getScaffoldersProvider(): ScaffolderProviderInterface
    {
        return $this->scaffoldersProvider;
    }

}
