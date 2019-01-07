<?php

namespace CrystalCode\Php\Common\Skeletons;

use CrystalCode\Php\Common\Collections\Collector;
use ReflectionClass as ClassReflection;

abstract class ClassReflectionProviderBase implements ClassReflectionProviderInterface
{

    /**
     * 
     * {@inheritdoc}
     */
    final public function getClassReflections(): iterable
    {
        $classNames = $this->getClassNames();

        $classReflections = Collector::create($classNames)
          ->map(function (string $className) {
            return new ClassReflection($className);
        });

        return $this->filterClassReflections($classReflections);
    }

    /**
     * 
     * @return iterable|string[]
     */
    abstract public function getClassNames(): iterable;

    /**
     * 
     * @param iterable|ClassReflection[] $classReflections
     * @return iterable|ClassReflection[]
     */
    protected function filterClassReflections(iterable $classReflections): iterable
    {
        return Collector::create($classReflections)
            ->filter(function (ClassReflection $classReflection) {
                if ($classReflection->isAbstract()) {
                    return false;
                }

                if ($classReflection->isAnonymous()) {
                    return false;
                }

                if ($classReflection->isAbstract()) {
                    return false;
                }

                if ($classReflection->isInternal()) {
                    return false;
                }

                return true;
            });
    }

}
