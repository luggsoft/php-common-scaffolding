<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

interface InstructionInterface
{

    /**
     * 
     * @param string $name
     * @return bool
     */
    function hasValue($name);

    /**
     * 
     * @param string $name
     * @return mixed
     */
    function getValue($name);

    /**
     * 
     * @param string $name
     * @param mixed $value
     * @return InstructionInterface
     */
    function withValue($name, $value);

    /**
     * 
     * @param mixed $values
     * @return InstructionInterface
     */
    function withValues($values);

}
