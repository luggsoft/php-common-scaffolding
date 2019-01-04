<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders;

interface ScaffolderProviderInterface
{

    /**
     * 
     * @return iterable|ScaffolderInterface[]
     */
    function getScaffolders(): iterable;

}
