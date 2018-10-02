<?php

namespace CrystalCode\Php\Common\Scaffolding\Templates;

use CrystalCode\Php\Common\Scaffolding\DefaultFileItem;
use CrystalCode\Php\Common\Templates\TemplateBase;
use CrystalCode\Php\Common\Templates\TemplateContextInterface;

final class ScssTemplateTemplate extends TemplateBase
{

    /**
     *
     * @var DefaultFileItem
     */
    private $fileItem;

    /**
     * 
     * @param DefaultFileItem $fileItem
     */
    public function __construct(DefaultFileItem $fileItem)
    {
        $this->fileItem = $fileItem;
    }

    /**
     * 
     * @param TemplateContextInterface $templateContext
     * @return void
     */
    protected function execute(TemplateContextInterface $templateContext)
    {
        ?>

        <?= '<?php' ?> 

        namespace <?= $this->getNamespaceName() ?>;

        final class <?= $this->getClassName() ?> 
        {

            /**
             *
             * @param TemplateContextInterface $templateContext
             * @return void
             */
            protected function execute(TemplateContextInterface $templateContext)
            {

                <?= '?>' ?> 

                <?= $this->getNamespaceName() ?>\<?= $this->getClassName() ?>;

                <?= '<?php' ?> 

            }

        }

        <?php
    }

    /**
     * 
     * @return string
     */
    private function getClassName()
    {
        $name = $this->fileItem->getName();
        return basename($name, '.php');
    }

    /**
     * 
     * @return string
     */
    private function getNamespaceName()
    {
        $segments = [];
        foreach ($this->fileItem->getAncestorItems(true) as $ancestorItem) {
            $segment = $ancestorItem->getName();
            $segments[] = $segment;
        }
        array_pop($segments);
        return implode('\\', $segments);
    }

}
