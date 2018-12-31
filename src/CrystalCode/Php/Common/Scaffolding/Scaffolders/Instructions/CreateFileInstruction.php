<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions;

use CrystalCode\Php\Common\Json\JsonValuesGetterInterface;
use CrystalCode\Php\Common\Json\JsonValuesSetterInterface;

final class CreateFileInstruction extends InstructionBase implements JsonValuesGetterInterface, JsonValuesSetterInterface
{

    /**
     *
     * @var string
     */
    private $path;

    /**
     *
     * @var string
     */
    private $contents;

    /**
     *
     * @var int
     */
    private $permissions;

    /**
     * 
     * @param string $path
     * @param string $contents
     * @param int $permissions
     */
    public function __construct(string $path, string $contents, int $permissions)
    {
        $this->path = $path;
        $this->contents = $contents;
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
     * @return string
     */
    public function getContents(): string
    {
        return (string) $this->contents;
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
              'contents'    => (string) $this->contents,
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
        $this->contents = (string) $jsonValues->contents;
        $this->permissions = (int) $jsonValues->permissions;
    }

}
