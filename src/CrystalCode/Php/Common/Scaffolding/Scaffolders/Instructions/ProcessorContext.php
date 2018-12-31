<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions;

use CrystalCode\Php\Common\ValuesObject;

final class ProcessorContext
{

    /**
     * 
     * @var string
     */
    const MODE_DEBUG = 'debug';

    /**
     * 
     * @var string
     */
    const MODE_EXECUTE = 'execute';

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
     * @return ValuesObject
     */
    public function getValuesObject(): ValuesObject
    {
        return $this->valuesObject;
    }

    /**
     * 
     * @return string
     */
    public function getMode(): string
    {
        return (string) $this->valuesObject->getValue('mode', self::MODE_DEBUG);
    }

}
