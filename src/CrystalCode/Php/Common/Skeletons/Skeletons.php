<?php

namespace CrystalCode\Php\Common\Skeletons;

use CrystalCode\Php\Common\Collections\Collector;
use CrystalCode\Php\Common\Templates\DelegateTemplate;
use CrystalCode\Php\Common\Templates\TemplateBase;
use CrystalCode\Php\Common\Templates\TemplateContextInterface;
use CrystalCode\Php\Common\Templates\TemplateInterface;
use ReflectionClass as ClassReflection;
use ReflectionMethod as MethodReflection;

final class TestTemplate extends TemplateBase
{

    /**
     *
     * @var ClassReflection
     */
    private $classReflection;

    /**
     * 
     * @param ClassReflection $classReflection
     */
    public function __construct(ClassReflection $classReflection)
    {
        $this->classReflection = $classReflection;
    }

    /**
     * 
     * {@inheritdoc}
     */
    protected function execute(TemplateContextInterface $templateContext): void
    {
        $className = $this->classReflection->getShortName();
        $namespaceName = $this->classReflection->getNamespaceName();

        ?>

        <?= '<?php' ?>

        namespace <?= $namespaceName ?>;

        class <?= $className ?>Test extends TestCase
        {

        <?php foreach ($this->classReflection->getMethods() as $methodReflection): ?>

            <?= $this->getMethodTemplate($methodReflection)->render($templateContext) ?>

        <?php endforeach; ?>

        }

        <?php

    }

    /**
     * 
     * @param MethodReflection $methodReflection
     * @return TemplateInterface
     */
    private function getMethodTemplate(MethodReflection $methodReflection): TemplateInterface
    {
        return new DelegateTemplate(function () use ($methodReflection) {
            $methodName = $methodReflection->getShortName();

            ?>

            public function <?= $methodName ?>Test(): void
            {
            $this->fail();
            }

            <?php

        });
    }

}

interface ClassReflectionProviderInterface
{

    /**
     * 
     * @return iterable|ClassReflection[]
     */
    function getClassReflections(): iterable;

}

abstract class ClassReflectionProviderBase implements ClassReflectionProviderInterface
{

    /**
     *
     * @var string
     */
    private $namespacePrefix;

    function __construct($namespacePrefix)
    {
        $this->namespacePrefix = $namespacePrefix;
    }

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

    /**
     * 
     * @param ClassReflection $classReflection
     * @param string $namespacePrefix
     * @return bool
     */
    private function inNamespace(ClassReflection $classReflection, string $namespacePrefix): bool
    {
        $namespaceName = $classReflection->getNamespaceName();
        $namespacePrefixLength = strlen($namespacePrefix);
        return substr_compare($namespaceName, $namespacePrefix, 0, $namespacePrefixLength, true) === 0;
    }

}

final class ClassReflectionProvider extends ClassReflectionProviderBase
{

    /**
     *
     * @var array|string[]
     */
    private $classNames = [];

    /**
     * 
     * @param string $namespacePrefix
     * @param iterable|string[] $classNames
     */
    function __construct(string $namespacePrefix, string ...$classNames)
    {
        parent::__construct($namespacePrefix);
        $this->classNames = $classNames;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getClassNames(): iterable
    {
        return $this->classNames;
    }

}

final class DeclaredClassReflectionProvider extends ClassReflectionProviderBase
{

    /**
     * 
     * @return iterable|string[]
     */
    public function getClassNames(): iterable
    {
        return get_declared_classes();
    }

}
