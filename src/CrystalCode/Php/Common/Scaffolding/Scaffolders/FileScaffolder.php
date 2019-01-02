<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders;

class FileScaffolder extends ScaffolderBase
{

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
     * @param PathProviderInterface $pathProvider
     * @param ContentsProviderInterface $contentsProvider
     * @param PermissionsProviderInterface $permissionsProvider
     */
    public function __construct(PathProviderInterface $pathProvider, ContentsProviderInterface $contentsProvider, PermissionsProviderInterface $permissionsProvider)
    {
        $this->pathProvider = $pathProvider;
        $this->contentsProvider = $contentsProvider;
        $this->permissionsProvider = $permissionsProvider;
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
     * @return ContentsProviderInterface
     */
    public function getContentsProvider(): ContentsProviderInterface
    {
        return $this->contentsProvider;
    }

    /**
     * 
     * @return PermissionsProviderInterface
     */
    public function getPermissionsProvider(): PermissionsProviderInterface
    {
        return $this->permissionsProvider;
    }

}
