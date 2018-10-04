<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

use CrystalCode\Php\Common\Collections\Collection;
use function CrystalCode\Php\Common\Scaffolding\interpolate;

final class CreateDirectoryInstruction extends InstructionBase
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
    public function getPath()
    {
        if (isset($this->values['path'])) {
            return $this->values['path'];
        }
        return null;
    }

}
