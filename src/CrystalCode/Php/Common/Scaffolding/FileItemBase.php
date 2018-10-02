<?php

namespace CrystalCode\Php\Common\Scaffolding;

use CrystalCode\Php\Common\Templates\TemplateInterface;

abstract class FileItemBase extends ItemBase
{

    /**
     * 
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);
    }

    /**
     * 
     * @return TemplateInterface
     */
    abstract public function getTemplate();

}
