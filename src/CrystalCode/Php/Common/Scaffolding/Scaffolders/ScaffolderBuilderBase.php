<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders;

use CrystalCode\Php\Common\ArgumentException;

abstract class ScaffolderBuilderBase
{

    /**
     * 
     * @param mixed $path
     * @return PathProviderInterface
     * @throws ArgumentException
     */
    final public static function normalizePath($path): PathProviderInterface
    {
        if ($path instanceof PathProviderInterface) {
            return $path;
        }

        if (is_callable($path)) {
            return new DelegatePathProvider($path);
        }

        if (is_string($path)) {
            return new DelegatePathProvider(function () use ($path) {
                return $path;
            });
        }

        throw new ArgumentException('path');
    }

    /**
     * 
     * @param mixed $permissions
     * @return PermissionsProviderInterface
     * @throws ArgumentException
     */
    public static function normalizePermissions($permissions): PermissionsProviderInterface
    {
        if ($permissions instanceof PermissionsProviderInterface) {
            return $permissions;
        }

        if (is_callable($permissions)) {
            return new DelegatePermissionsProvider($permissions);
        }

        if (is_string($permissions)) {
            return new DelegatePermissionsProvider(function () use ($permissions) {
                $value = 0;

                for ($index = 0; $index < 3; $index++) {
                    $value += ($permissions[($index * 3) + 0] === 'r') ? (4 * pow(8, $index)) : 0;
                    $value += ($permissions[($index * 3) + 1] === 'w') ? (2 * pow(8, $index)) : 0;
                    $value += ($permissions[($index * 3) + 2] === 'x') ? (1 * pow(8, $index)) : 0;
                }

                return $value;
            });
        }

        if (is_int($permissions)) {
            return new DelegatePermissionsProvider(function () use ($permissions) {
                return $permissions;
            });
        }

        throw new ArgumentException('permissions');
    }

}
