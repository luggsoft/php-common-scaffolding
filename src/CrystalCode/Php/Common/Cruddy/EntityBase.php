<?php

namespace CrystalCode\Php\Common\Cruddy;

abstract class EntityBase implements EntityInterface
{

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var array|Property[]
     */
    private $properties = [];

    /**
     * 
     * @param string $name
     */
    public function __construct(string $name, Property ...$properties)
    {
        $this->name = $name;
        $this->properties = $properties;
    }

    /**
     * 
     * {@inheritdoc}
     */
    final public function getName(): string
    {
        return $this->name;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getProperties(): iterable
    {
        return $this->properties;
    }

}
