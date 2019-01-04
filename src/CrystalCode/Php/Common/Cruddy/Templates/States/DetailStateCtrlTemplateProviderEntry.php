<?php

namespace CrystalCode\Php\Common\Cruddy\Templates\States;

use CrystalCode\Php\Common\Cruddy\EntityInterface;
use CrystalCode\Php\Common\Scaffolding\Templates\TemplateProviderEntryBase;
use CrystalCode\Php\Common\Scaffolding\Util\Identifier;
use CrystalCode\Php\Common\Templates\DelegateTemplate;
use CrystalCode\Php\Common\Templates\TemplateInterface;

final class DetailStateCtrlTemplateProviderEntry extends TemplateProviderEntryBase
{

    /**
     * 
     * {@inheritdoc}
     */
    public function getApplicability($values): int
    {
        $total = 0;

        if ($values->entity instanceof EntityInterface) {
            if ($values->state === 'detail' && $values->type === 'ctrl') {
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
                    $stateProvider.state('app.<?= $singleFieldEntityName ?>.detail', new detailState());
                    
                    function detailState() {
                        return _.defaults(this, {
                            url: '/detail/{id}',
                            templateUrl: 'src/cruddy/states/app/<?= $singleFieldEntityName ?>/detail/detail.html',
                            controller: ['$scope', '$state', '<?= $singleFieldEntityName ?>', controller],
                            resolve: {
                                <?= $singleFieldEntityName ?>: ['$stateParams', 'apiClientService', resolve<?= $singleClassEntityName ?>],
                            },
                            redirectTo: 'app.<?= $singleFieldEntityName ?>.detail.view',
                            bindToController: true,
                            controllerAs: 'self',
                        });
                        
                        function resolve<?= $singleClassEntityName ?>($stateParams, apiClientService) {
                            return apiClientService.select<?= $singleClassEntityName ?>ById($stateParams.id);
                        }
                        
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
