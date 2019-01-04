<?php

namespace CrystalCode\Php\Common\Scaffolding\Templates;

interface TemplateProviderEntryInterface extends TemplateProviderInterface
{

    /**
     * 
     * @param mixed $values
     * @return int
     */
    function getApplicability($values): int;

}
