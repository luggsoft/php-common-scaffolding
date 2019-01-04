<?php

namespace CrystalCode\Php\Common\Cruddy\Templates\States;

use CrystalCode\Php\Common\Cruddy\EntityInterface;
use CrystalCode\Php\Common\Scaffolding\Templates\TemplateProviderEntryBase;
use CrystalCode\Php\Common\Scaffolding\Util\Identifier;
use CrystalCode\Php\Common\Templates\DelegateTemplate;
use CrystalCode\Php\Common\Templates\TemplateInterface;

final class RootStateCtrlTemplateProviderEntry extends TemplateProviderEntryBase
{

    /**
     * 
     * {@inheritdoc}
     */
    public function getApplicability($values): int
    {
        $total = 0;

        if ($values->entity instanceof EntityInterface) {
            if ($values->state === 'root' && $values->type === 'ctrl') {
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
                
                angular.module('cruddy').config(['$stateProvider', rootStateConfig]);
                
                function rootStateConfig($stateProvider) {
                    $stateProvider.state('app.<?= $singleFieldEntityName ?>', new rootState());
                    
                    function rootState() {
                        return _.defaults(this, {
                            url: '/<?= $singleFieldEntityName ?>',
                            templateUrl: 'src/cruddy/states/app/<?= $singleFieldEntityName ?>/<?= $singleFieldEntityName ?>.html',
                            controller: ['$scope', '$state', controller],
                            redirectTo: 'app.<?= $singleFieldEntityName ?>.select',
                            bindToController: true,
                            controllerAs: 'self',
                        });
                        
                        function controller($scope, $state) {
                            const self = _.defaults(this, {
                                isDetailState: false,
                            });
                            
                            $scope.$watch(() => $state.includes('app.<?= $singleFieldEntityName ?>.detail'), isDetailState => self.isDetailState = isDetailState);
                        }
                    }
                }
            })();

            <?php

        });
    }

}
