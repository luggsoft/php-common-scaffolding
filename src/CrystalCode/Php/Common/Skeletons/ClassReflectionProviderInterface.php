<?php

namespace CrystalCode\Php\Common\Skeletons;

use ReflectionClass as ClassReflection;

interface ClassReflectionProviderInterface
{

    /**
     * 
     * @return iterable|ClassReflection[]
     */
    function getClassReflections(): iterable;

}
