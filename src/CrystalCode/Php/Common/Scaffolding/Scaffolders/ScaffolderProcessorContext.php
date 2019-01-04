<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders;

use CrystalCode\Php\Common\ValuesObject;

final class ScaffolderProcessorContext
{

    /**
     *
     * @var ValuesObject
     */
    private $valuesObject;

    /**
     * 
     * @param mixed $values
     */
    public function __construct($values = [])
    {
        $this->valuesObject = ValuesObject::create($values);
    }

    /**
     * 
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->getValue($name);
    }

    /**
     * 
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, $value): void
    {
        $this->setValue($name, $value);
    }

    /**
     * 
     * @return ValuesObject
     */
    public function getValuesObject(): ValuesObject
    {
        return $this->valuesObject;
    }

    /**
     * 
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getValue(string $name, $default = null)
    {
        return $this->valuesObject->getValue($name, $default);
    }

    /**
     * 
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setValue(string $name, $value): void
    {
        $this->valuesObject->setValue($name, $value);
    }

    /**
     * 
     * @param string $name
     * @param mixed $value
     * @return ScaffolderProcessorContext
     */
    public function withValue(string $name, $value): ScaffolderProcessorContext
    {
        $clone = clone $this;
        $clone->valuesObject = $clone->valuesObject->withValue($name, $value);
        return $clone;
    }

}
