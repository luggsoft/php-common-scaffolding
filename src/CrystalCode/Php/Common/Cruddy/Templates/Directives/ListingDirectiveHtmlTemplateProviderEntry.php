<?php

namespace CrystalCode\Php\Common\Cruddy\Templates\Directives;

use CrystalCode\Php\Common\Cruddy\EntityInterface;
use CrystalCode\Php\Common\Scaffolding\Templates\TemplateProviderEntryBase;
use CrystalCode\Php\Common\Scaffolding\Util\Identifier;
use CrystalCode\Php\Common\Templates\DelegateTemplate;
use CrystalCode\Php\Common\Templates\TemplateInterface;

final class ListingDirectiveHtmlTemplateProviderEntry extends TemplateProviderEntryBase
{

    /**
     * 
     * {@inheritdoc}
     */
    public function getApplicability($values): int
    {
        $total = 0;

        if ($values->entity instanceof EntityInterface) {
            if ($values->directive === 'listing' && $values->type === 'html') {
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

            <table class="table">
                <thead>
                    <tr>

                        <?php foreach ($entity->getProperties() as $property): ?>

                            <?php

                            $propertyName = $property->getName();
                            $singleTitlePropertyName = Identifier::getSingleTitleName($propertyName);

                            ?>

                            <th>
                                <span><?= $singleTitlePropertyName ?></span>
                            </th>

                        <?php endforeach; ?>

                        <th>&nbsp;</th>

                    </tr>
                </thead>

                <tbody>
                    <tr ng-repeat="<?= $singleFieldEntityName ?> in self.<?= $pluralFieldEntityName ?>">

                        <?php foreach ($entity->getProperties() as $property): ?>

                            <?php

                            $propertyName = $property->getName();
                            $singleFieldPropertyName = Identifier::getSingleFieldName($propertyName);

                            ?>

                            <td>
                                <span ng-bind="<?= $singleFieldEntityName ?>.<?= $singleFieldPropertyName ?>"></span>
                            </td>

                        <?php endforeach; ?>

                        <td>
                            <button class="btn btn-link">
                                <span class="fa fa-fw fa-cube"></span>
                                <span>View</span>
                            </button>

                            <button class="btn btn-link">
                                <span class="fa fa-fw fa-cube"></span>
                                <span>Edit</span>
                            </button>
                        </td>

                    </tr>
                </tbody>


            </table>

            <?php

        });
    }

}
