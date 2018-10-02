<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

use CrystalCode\Php\Common\Collections\Collection;
use function CrystalCode\Php\Common\Scaffolding\interpolate;

final class CreateFileInstruction extends InstructionBase
{

    /**
     *
     * @var array
     */
    private $values = [];

    /**
     * 
     * @param mixed $values
     */
    public function __construct($values)
    {
        $this->values = Collection::create($values)->toArray();
    }

    /**
     * 
     * @return string
     */
    public function toString()
    {
        $path = null;
        $data = null;
        if (isset($this->values['path'])) {
            $path = $this->values['path'];
        }
        if (isset($this->values['data'])) {
            $data = $this->values['data'];
        }
        return interpolate('New-Item -Force -ItemType File -Path ".\\{path}" -Value @"{data}"@;' . PHP_EOL, [
            'path' => strtr($path, '/', '\\'),
            'data' => PHP_EOL . trim($data) . PHP_EOL,
        ]);
    }

    /**
     * 
     * @return string
     */
    public function getPath()
    {
        if (isset($this->values['path'])) {
            return $this->values['path'];
        }
        return null;
    }

    /**
     * 
     * @return string
     */
    public function getData()
    {
        if (isset($this->values['data'])) {
            return $this->values['data'];
        }
        return null;
    }

}
