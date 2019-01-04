<?php

namespace CrystalCode\Php\Common\Cruddy\Templates\States;

use CrystalCode\Php\Common\Cruddy\EntityInterface;
use CrystalCode\Php\Common\Scaffolding\Templates\TemplateProviderEntryBase;
use CrystalCode\Php\Common\Scaffolding\Util\Identifier;
use CrystalCode\Php\Common\Templates\DelegateTemplate;
use CrystalCode\Php\Common\Templates\TemplateInterface;

final class RootStateHtmlTemplateProviderEntry extends TemplateProviderEntryBase
{

    /**
     * 
     * {@inheritdoc}
     */
    public function getApplicability($values): int
    {
        $total = 0;

        if ($values->entity instanceof EntityInterface) {
            if ($values->state === 'root' && $values->type === 'html') {
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
            $entityName = $values->entity->getName();
            $singleTitleEntityName = Identifier::getSingleTitleName($entityName);

            ?>

            <nav class="clearfix">
                <ul class="nav nav-tabs">
                    <li ui-sref-active="active">
                        <a href ui-sref=".select">
                            <span class="fa fa-fw fa-cube"></span>
                            <span>Select <?= $singleTitleEntityName ?></span>
                        </a>
                    </li>

                    <li ui-sref-active="active">
                        <a href ui-sref=".create">
                            <span class="fa fa-fw fa-cube"></span>
                            <span>Create <?= $singleTitleEntityName ?></span>
                        </a>
                    </li>

                    <li ui-sref-active="active" ng-if="self.isDetailState">
                        <a href ui-sref=".detail">
                            <span class="fa fa-fw fa-cube"></span>
                            <span><?= $singleTitleEntityName ?> Detail</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="clearfix" ui-view></div>

            <?php

        });
    }

}
