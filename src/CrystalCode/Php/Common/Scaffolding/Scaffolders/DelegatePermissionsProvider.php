<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders;

final class DelegatePermissionsProvider implements PermissionsProviderInterface
{

    /**
     *
     * @var callable
     */
    private $getPermissionsDelegate;

    /**
     * 
     * @param callable $getPermissionsDelegate
     */
    public function __construct(callable $getPermissionsDelegate)
    {
        $this->getPermissionsDelegate = $getPermissionsDelegate;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getPermissions(): int
    {
        return (int) call_user_func($this->getPermissionsDelegate);
    }

}
