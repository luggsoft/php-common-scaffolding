<?php

namespace CrystalCode\Php\Common\Cruddy\Templates\States;

use CrystalCode\Php\Common\Cruddy\EntityInterface;
use CrystalCode\Php\Common\Scaffolding\Templates\TemplateProviderEntryBase;
use CrystalCode\Php\Common\Scaffolding\Util\Identifier;
use CrystalCode\Php\Common\Templates\DelegateTemplate;
use CrystalCode\Php\Common\Templates\TemplateInterface;

final class ViewDetailStateHtmlTemplateProviderEntry extends TemplateProviderEntryBase
{

    /**
     * 
     * {@inheritdoc}
     */
    public function getApplicability($values): int
    {
        $total = 0;

        if ($values->entity instanceof EntityInterface) {
            if ($values->state === 'view' && $values->type === 'html') {
                $total += 10;
            }
        }

        return $total;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getTemplate($values): TemplateInterface
    {
        return new DelegateTemplate(function () use ($values) {
            $xhtmlPrefix = 'crud';
            $entityName = $values->entity->getName();
            $singleFieldEntityName = Identifier::getSingleFieldName($entityName);
            $singleXhtmlEntityName = Identifier::getSingleXhtmlName($entityName);

            ?>

            <div class="clearfix"
                 <?= $xhtmlPrefix ?>-<?= $singleXhtmlEntityName ?>-viewer
                 <?= $singleXhtmlEntityName ?>="self.<?= $singleFieldEntityName ?>" 
                 on-event="self.handleEvent(event)">
            </div>

            <?php

        });
    }

}
