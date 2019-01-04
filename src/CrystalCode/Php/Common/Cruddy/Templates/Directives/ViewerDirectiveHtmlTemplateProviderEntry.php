<?php

namespace CrystalCode\Php\Common\Cruddy\Templates\Directives;

use CrystalCode\Php\Common\Cruddy\EntityInterface;
use CrystalCode\Php\Common\Scaffolding\Templates\TemplateProviderEntryBase;
use CrystalCode\Php\Common\Scaffolding\Util\Identifier;
use CrystalCode\Php\Common\Templates\DelegateTemplate;
use CrystalCode\Php\Common\Templates\TemplateInterface;

final class ViewerDirectiveHtmlTemplateProviderEntry extends TemplateProviderEntryBase
{

    /**
     * 
     * {@inheritdoc}
     */
    public function getApplicability($values): int
    {
        $total = 0;

        if ($values->entity instanceof EntityInterface) {
            if ($values->directive === 'viewer' && $values->type === 'html') {
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
            $entity = $values->entity;
            $entityName = $values->entity->getName();
            $singleFieldEntityName = Identifier::getSingleFieldName($entityName);
            $singleXhtmlEntityName = Identifier::getSingleXhtmlName($entityName);
            $pluralFieldEntityName = Identifier::getPluralFieldName($entityName);
            $pluralXhtmlEntityName = Identifier::getPluralXhtmlName($entityName);

            ?>

            <div class="clearfix">

                <?php foreach ($entity->getProperties() as $property): ?>

                    <?php

                    $propertyName = $property->getName();
                    $singleFieldPropertyName = Identifier::getSingleFieldName($propertyName);
                    $singleTitlePropertyName = Identifier::getSingleTitleName($propertyName);

                    ?>

                    <div class="form-group">
                        <label class="control-label">
                            <span><?= $singleTitlePropertyName ?></span>
                        </label>
                        <span class="form-control-static" ng-bind="self.<?= $singleFieldEntityName ?>.<?= $singleFieldPropertyName ?>" />
                    </div>

                <?php endforeach; ?>    

            </div>

            <?php

        });
    }

}
