<?php

namespace CrystalCode\Php\Common\Skeletons\Templates;

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
        
        use PHPUnit\Framework\TestCase;

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
