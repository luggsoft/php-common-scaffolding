<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions;

use CrystalCode\Php\Common\Json\JsonValuesGetterInterface;
use CrystalCode\Php\Common\Json\JsonValuesSetterInterface;

final class RemoveFileInstruction extends InstructionBase implements JsonValuesGetterInterface, JsonValuesSetterInterface
{

    /**
     *
     * @var string
     */
    private $path;

    /**
     * 
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getJsonValues(): object
    {
        return (object) [
              'path' => (string) $this->path,
        ];
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function setJsonValues(object $jsonValues): void
    {
        $this->path = $jsonValues->path;
    }

}
