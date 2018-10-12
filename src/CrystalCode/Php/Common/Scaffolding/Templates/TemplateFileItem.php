<?php

namespace CrystalCode\Php\Common\Scaffolding\Templates;

use CrystalCode\Php\Common\Scaffolding\FileItemBase;

final class TemplateFileItem extends FileItemBase
{

    /**
     * 
     * @param string $name
     * @param string $extension
     */
    public function __construct($name, $extension)
    {
        parent::__construct($name, $extension);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return new TemplateFileItemTemplate($this);
    }

}
