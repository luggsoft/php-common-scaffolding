<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

use CrystalCode\Php\Common\Collections\Collection;

abstract class InstructionBase implements InstructionInterface
{

    /**
     *
     * @var array
     */
    private $values = [];

    /**
     * 
     * {@inheritdoc}
     */
    final public function hasValue($name)
    {
        return isset($this->values[$name]);
    }

    /**
     * 
     * {@inheritdoc}
     */
    final public function getValue($name)
    {
        if (isset($this->values[$name])) {
            return $this->values[$name];
        }
        return null;
    }

    /**
     * 
     * {@inheritdoc}
     */
    final public function withValue($name, $value)
    {
        $clone = clone $this;
        $clone->setValue($name, $value);
        return $clone;
    }

    /**
     * 
     * {@inheritdoc}
     */
    final public function withValues($values)
    {
        $clone = clone $this;
        $clone->setValues($values);
        return $clone;
    }

    /**
     * 
     * @param string $name
     * @param mixed $value
     * @return void
     */
    final protected function setValue($name, $value)
    {
        $this->values[(string) $name] = $value;
    }

    /**
     * 
     * @param mixed[] $values
     * @return void
     */
    final protected function setValues($values)
    {
        foreach (Collection::create($values) as $name => $value) {
            $this->setValue($name, $value);
        }
    }

}
