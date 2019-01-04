<?php

namespace CrystalCode\Php\Common\Cruddy;

final class Property
{

    /**
     *
     * @var string
     */
    private $name;

    /**
     * 
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}
