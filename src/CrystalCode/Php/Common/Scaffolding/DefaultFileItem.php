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
     * @param callable $templateProvider
     */
    public function __construct($name, callable $templateProvider)
    {
        parent::__construct($name);
        $template = call_user_func($templateProvider, $this);
        $this->setTemplate($template);
    }

    /**
     * 
     * @return TemplateInterface
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * 
     * @param TemplateInterface $template
     * @return void
     */
    private function setTemplate(TemplateInterface $template)
    {
        $this->template = $template;
    }

}
