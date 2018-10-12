<?php

namespace CrystalCode\Php\Common\Scaffolding\Templates;

use CrystalCode\Php\Common\Scaffolding\FileItemBase;
use CrystalCode\Php\Common\Templates\TemplateContextInterface;

final class TemplateFileItemTemplate extends FileItemTemplateBase
{

    /**
     * 
     * @param FileItemBase $fileItem
     */
    public function __construct(FileItemBase $fileItem)
    {
        parent::__construct($fileItem);
    }

    /**
     * 
     * {@inheritdoc}
     */
    protected function execute(TemplateContextInterface $templateContext)
    {
        ?>

        <?= '<?php' ?> 

        namespace <?= $this->getNamespaceName() ?>;
        
        use CrystalCode\Php\Common\Templates\TemplateBase;
        use CrystalCode\Php\Common\Templates\TemplateContextInterface;

        final class <?= $this->getClassName() ?> extends TemplateBase
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
    public function getClassName()
    {
        return $this->getFileItem()->getName();
    }

    /**
     * 
     * @return string
     */
    public function getNamespaceName()
    {
        $nameSegments = [];
        foreach ($this->getFileItem()->getAncestorItems(false) as $item) {
            $nameSegments[] = $item->getName();
        }
        return implode('\\', $nameSegments);
    }

}
