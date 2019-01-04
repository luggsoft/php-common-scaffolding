<?php

namespace CrystalCode\Php\Common\Cruddy\Templates\States;

use CrystalCode\Php\Common\Cruddy\EntityInterface;
use CrystalCode\Php\Common\Scaffolding\Templates\TemplateProviderEntryBase;
use CrystalCode\Php\Common\Scaffolding\Util\Identifier;
use CrystalCode\Php\Common\Templates\DelegateTemplate;
use CrystalCode\Php\Common\Templates\TemplateInterface;

final class CreateStateCtrlTemplateProviderEntry extends TemplateProviderEntryBase
{

    /**
     * 
     * {@inheritdoc}
     */
    public function getApplicability($values): int
    {
        $total = 0;

        if ($values->entity instanceof EntityInterface) {
            if ($values->state === 'create' && $values->type === 'ctrl') {
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
                
                angular.module('cruddy').config(['$stateProvider', createStateConfig]);
                
                function createStateConfig($stateProvider) {
                    $stateProvider.state('app.<?= $singleFieldEntityName ?>.create', new createState());
                    
                    function createState() {
                        return _.defaults(this, {
                            url: '/create?cloneId',
                            templateUrl: 'src/cruddy/states/app/<?= $singleFieldEntityName ?>/create/create.html',
                            controller: ['$scope', '$state', '$stateParams', 'apiClientService', controller],
                            bindToController: true,
                            controllerAs: 'self',
                        });
                        
                        function controller($scope, $state, $stateParams, apiClientService) {
                            const self = _.defaults(this, {
                                cloneId: _.get($stateParams, ['cloneId']),
                                <?= $singleFieldEntityName ?>: {},
                                create<?= $singleClassEntityName ?>: create<?= $singleClassEntityName ?>,
                                handleEvent: handleEvent,
                            });
                            
                            if (self.cloneId) {
                                apiClientService.select<?= $singleClassEntityName ?>ById(self.cloneId)
                                    .then(<?= $singleFieldEntityName ?> => self.<?= $singleFieldEntityName ?> = <?= $singleFieldEntityName ?>)
                                    .catch(error => console.error(error));
                            }
                            
                            function create<?= $singleClassEntityName ?>() {
                                apiClientService.create<?= $singleClassEntityName ?>(self.<?= $singleFieldEntityName ?>)
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
