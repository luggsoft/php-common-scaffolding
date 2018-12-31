<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Templates;

interface TemplateProviderEntryInterface extends TemplateProviderInterface
{

    /**
     * 
     * @param mixed $values
     * @return int
     */
    function getApplicability($values): int;

}
