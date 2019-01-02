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
     * @var ScaffoldersProviderInterface
     */
    private $scaffoldersProvider;

    /**
     * 
     * @param PathProviderInterface $pathProvider
     * @param PermissionsProviderInterface $permissionsProvider
     * @param ScaffoldersProviderInterface $scaffoldersProvider
     */
    public function __construct(PathProviderInterface $pathProvider, PermissionsProviderInterface $permissionsProvider, ScaffoldersProviderInterface $scaffoldersProvider = null)
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
     * @return ScaffoldersProviderInterface
     */
    public function getScaffoldersProvider(): ScaffoldersProviderInterface
    {
        return $this->scaffoldersProvider;
    }

}
