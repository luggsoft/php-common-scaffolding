<?php

namespace CrystalCode\Php\Common\Scaffolding;

use CrystalCode\Php\Common\Templates\TemplateInterface;

abstract class FileItemBase extends ItemBase
{

    /**
     *
     * @var string
     */
    private $extension;

    /**
     * 
     * @param string $name
     */
    public function __construct($name, $extension)
    {
        parent::__construct($name);
        $this->extension = (string) $extension;
    }

    /**
     * 
     * @return string
     */
    final public function getExtension()
    {
        return $this->extension;
    }

    /**
     * 
     * @return TemplateInterface
     */
    abstract public function getTemplate();

}
