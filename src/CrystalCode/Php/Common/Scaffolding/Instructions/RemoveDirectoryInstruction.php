<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

use CrystalCode\Php\Common\Json\JsonValuesGetterInterface;
use CrystalCode\Php\Common\Json\JsonValuesSetterInterface;

final class RemoveDirectoryInstruction extends InstructionBase implements JsonValuesGetterInterface, JsonValuesSetterInterface
{

    /**
     *
     * @var string
     */
    private $path;

    /**
     *
     * @var bool
     */
    private $force;

    /**
     *
     * @var bool
     */
    private $recursive;

    /**
     * 
     * @param string $path
     * @param bool $force
     * @param bool $recursive
     */
    public function __construct(string $path, bool $force, bool $recursive)
    {
        $this->path = $path;
        $this->force = $force;
        $this->recursive = $recursive;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * 
     * @return bool
     */
    public function getForce(): bool
    {
        return $this->force;
    }

    /**
     * 
     * @return bool
     */
    public function getRecursive(): bool
    {
        return $this->recursive;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getJsonValues(): object
    {
        return (object) [
              'path'      => (string) $this->path,
              'force'     => (bool) $this->force,
              'recursive' => (bool) $this->recursive,
        ];
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function setJsonValues(object $jsonValues): void
    {
        $this->path = (string) $jsonValues->path;
        $this->force = (bool) $jsonValues->force;
        $this->recursive = (bool) $jsonValues->recursive;
    }

}
