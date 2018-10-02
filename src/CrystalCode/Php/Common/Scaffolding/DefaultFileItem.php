<?php

namespace CrystalCode\Php\Common\Scaffolding;

use CrystalCode\Php\Common\Templates\TemplateInterface;

final class DefaultFileItem extends FileItemBase
{

    /**
     *
     * @var TemplateInterface
     */
    private $template;

    /**
     * 
     * @param string $name
     */
    public function __construct($name, TemplateInterface $template)
    {
        parent::__construct($name);
        $this->template = $template;
    }

    /**
     * 
     * @return TemplateInterface
     */
    public function getTemplate()
    {
        return $this->template;
    }

}
