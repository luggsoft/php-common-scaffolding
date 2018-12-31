<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions;

use CrystalCode\Php\Common\Json\JsonValuesGetterInterface;
use CrystalCode\Php\Common\Json\JsonValuesSetterInterface;

final class CreateDirectoryInstruction extends InstructionBase implements JsonValuesGetterInterface, JsonValuesSetterInterface
{

    /**
     *
     * @var string
     */
    private $path;

    /**
     *
     * @var int
     */
    private $permissions;

    /**
     * 
     * @param string $path
     * @param int $permissions
     */
    public function __construct(string $path, int $permissions)
    {
        $this->path = $path;
        $this->permissions = $permissions;
    }

    /**
     * 
     * @return string
     */
    public function getPath(): string
    {
        return (string) $this->path;
    }

    /**
     * 
     * @return int
     */
    public function getPermissions(): int
    {
        return (int) $this->permissions;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getJsonValues(): object
    {
        return (object) [
              'path'        => (string) $this->path,
              'permissions' => (int) $this->permissions,
        ];
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function setJsonValues(object $jsonValues): void
    {
        $this->path = (string) $jsonValues->path;
        $this->permissions = (int) $jsonValues->permissions;
    }

}
