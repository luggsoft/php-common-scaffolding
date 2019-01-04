<?php

namespace CrystalCode\Php\Common\Cruddy\Templates\States;

use CrystalCode\Php\Common\Cruddy\EntityInterface;
use CrystalCode\Php\Common\Scaffolding\Templates\TemplateProviderEntryBase;
use CrystalCode\Php\Common\Scaffolding\Util\Identifier;
use CrystalCode\Php\Common\Templates\DelegateTemplate;
use CrystalCode\Php\Common\Templates\TemplateInterface;

final class ViewDetailStateCtrlTemplateProviderEntry extends TemplateProviderEntryBase
{

    /**
     * 
     * {@inheritdoc}
     */
    public function getApplicability($values): int
    {
        $total = 0;

        if ($values->entity instanceof EntityInterface) {
            if ($values->state === 'view' && $values->type === 'ctrl') {
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
            $singleFieldEntityName = Identifier::getSingleFieldName($entityName);

            ?>

            (() => {
                'use strict';
                
                angular.module('cruddy').config(['$stateProvider', detailStateConfig]);
                
                function detailStateConfig($stateProvider) {
                    $stateProvider.state('app.<?= $singleFieldEntityName ?>.detail.view', new detailState());
                    
                    function detailState() {
                        return _.defaults(this, {
                            url: '/view',
                            templateUrl: 'src/cruddy/states/app/<?= $singleFieldEntityName ?>/detail/view/view.html',
                            controller: ['$scope', '$state', '<?= $singleFieldEntityName ?>', controller],
                            bindToController: true,
                            controllerAs: 'self',
                        });
                        
                        function controller($scope, $state, <?= $singleFieldEntityName ?>) {
                            const self = _.defaults(this, {
                                <?= $singleFieldEntityName ?>: <?= $singleFieldEntityName ?>,
                                handleEvent: handleEvent,
                            });
                            
                            function handleEvent(event) {
                                switch (_.get(event, ['name'])) {
                                    default:
                                        console.log(event);
                                        break;
                                }
                            }
                        }
                    }
                }
            })();

            <?php

        });
    }

}
