<?php

namespace CrystalCode\Php\Common\Scaffolding\Templates;

use CrystalCode\Php\Common\Templates\TemplateInterface;

interface TemplateProviderInterface
{

    /**
     * 
     * @param mixed $values
     * @return TemplateInterface
     */
    function getTemplate($values): TemplateInterface;

}
