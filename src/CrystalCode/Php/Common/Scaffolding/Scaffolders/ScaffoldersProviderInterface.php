<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders;

interface ScaffoldersProviderInterface
{

    /**
     * 
     * @return iterable|ScaffolderInterface[]
     */
    function getScaffolders(): iterable;

}
