<?php

namespace CrystalCode\Php\Common\Cruddy\Templates\States;

use CrystalCode\Php\Common\Cruddy\EntityInterface;
use CrystalCode\Php\Common\Scaffolding\Templates\TemplateProviderEntryBase;
use CrystalCode\Php\Common\Scaffolding\Util\Identifier;
use CrystalCode\Php\Common\Templates\DelegateTemplate;
use CrystalCode\Php\Common\Templates\TemplateInterface;

final class EditDetailStateCtrlTemplateProviderEntry extends TemplateProviderEntryBase
{

    /**
     * 
     * {@inheritdoc}
     */
    public function getApplicability($values): int
    {
        $total = 0;

        if ($values->entity instanceof EntityInterface) {
            if ($values->state === 'edit' && $values->type === 'ctrl') {
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
            $singleClassEntityName = Identifier::getSingleClassName($entityName);
            
            ?>

            (() => {
                'use strict';
                
                angular.module('cruddy').config(['$stateProvider', detailStateConfig]);
                
                function detailStateConfig($stateProvider) {
                    $stateProvider.state('app.<?= $singleFieldEntityName ?>.detail.edit', new detailState());
                    
                    function detailState() {
                        return _.defaults(this, {
                            url: '/view',
                            templateUrl: 'src/cruddy/states/app/<?= $singleFieldEntityName ?>/detail/edit/edit.html',
                            controller: ['$scope', '$state', 'apiClientService', '<?= $singleFieldEntityName ?>', controller],
                            bindToController: true,
                            controllerAs: 'self',
                        });
                        
                        function controller($scope, $state, apiClientService, <?= $singleFieldEntityName ?>) {
                            const self = _.defaults(this, {
                                <?= $singleFieldEntityName ?>: <?= $singleFieldEntityName ?>,
                                update<?= $singleClassEntityName ?>: update<?= $singleClassEntityName ?>,
                                handleEvent: handleEvent,
                            });
                            
                            function update<?= $singleClassEntityName ?>() {
                                apiClientService.update<?= $singleClassEntityName ?>(self.<?= $singleFieldEntityName ?>)
                                    .then(() => $state.go('^'))
                                    .catch(error => console.error(error));
                            }
                            
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
