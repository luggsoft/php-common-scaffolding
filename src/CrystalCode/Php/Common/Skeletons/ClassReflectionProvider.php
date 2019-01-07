<?php

namespace CrystalCode\Php\Common\Skeletons;

use CrystalCode\Php\Common\Collections\Collector;
use ReflectionClass as ClassReflection;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

final class ClassReflectionProvider extends ClassReflectionProviderBase
{

    /**
     *
     * @var string
     */
    private $path;

    /**
     *
     * @var string
     */
    private $namespaceName;

    /**
     * 
     * @param string $path
     * @param string $namespaceName
     */
    public function __construct(string $path, string $namespaceName)
    {
        $this->path = $path;
        $this->namespaceName = $namespaceName;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getClassNames(): iterable
    {
        foreach ($this->getPaths() as $path) {
            (function () use ($path) {
                require_once $path;
            })();
        }

        return get_declared_classes();
    }

    /**
     * 
     * {@inheritdoc}
     */
    protected function filterClassReflections(iterable $classReflections): iterable
    {
        $classReflections = parent::filterClassReflections($classReflections);

        return Collector::create($classReflections)
            ->filter(function (ClassReflection $classReflection) {
                $namespaceName = $classReflection->getNamespaceName();
                $namespaceNameLength = strlen($this->namespaceName);

                if ($namespaceNameLength > strlen($namespaceName)) {
                    return false;
                }

                return substr_compare($namespaceName, $this->namespaceName, 0, $namespaceNameLength, true) === 0;
            });
    }

    /**
     * 
     * @return iterable|string[]
     */
    private function getPaths(): iterable
    {
        $finder = Finder::create()
          ->in($this->path)
          ->name('*.php')
          ->getIterator();

        return Collector::create($finder)
            ->map(function (SplFileInfo $splFileInfo) {
                return $splFileInfo->getRealPath();
            });
    }

}
