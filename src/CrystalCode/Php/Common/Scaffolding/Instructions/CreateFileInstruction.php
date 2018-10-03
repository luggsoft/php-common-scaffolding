<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

use CrystalCode\Php\Common\Collections\Collection;

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
