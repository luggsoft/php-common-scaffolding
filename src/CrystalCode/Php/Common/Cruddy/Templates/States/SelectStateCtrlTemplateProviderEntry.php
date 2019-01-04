<?php

namespace CrystalCode\Php\Common\Cruddy\Templates\States;

use CrystalCode\Php\Common\Cruddy\EntityInterface;
use CrystalCode\Php\Common\Scaffolding\Templates\TemplateProviderEntryBase;
use CrystalCode\Php\Common\Scaffolding\Util\Identifier;
use CrystalCode\Php\Common\Templates\DelegateTemplate;
use CrystalCode\Php\Common\Templates\TemplateInterface;

final class SelectStateCtrlTemplateProviderEntry extends TemplateProviderEntryBase
{

    /**
     * 
     * {@inheritdoc}
     */
    public function getApplicability($values): int
    {
        $total = 0;

        if ($values->entity instanceof EntityInterface) {
            if ($values->state === 'select' && $values->type === 'ctrl') {
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
            $pluralFieldEntityName = Identifier::getPluralFieldName($entityName);
            $pluralClassEntityName = Identifier::getPluralClassName($entityName);

            ?>

            (() => {
                'use strict';
                
                angular.module('cruddy').config(['$stateProvider', selectStateConfig]);
                
                function selectStateConfig($stateProvider) {
                    $stateProvider.state('app.<?= $singleFieldEntityName ?>.select', new selectState());
                    
                    function selectState() {
                        return _.defaults(this, {
                            url: '/select',
                            templateUrl: 'src/cruddy/states/app/<?= $singleFieldEntityName ?>/select/select.html',
                            controller: ['$scope', '$state', 'apiClientService', controller],
                            bindToController: true,
                            controllerAs: 'self',
                        });
                        
                        function controller($scope, $state, apiClientService) {
                            const self = _.defaults(this, {
                                <?= $pluralFieldEntityName ?>: [],
                            });
                            
                            load<?= $pluralClassEntityName ?>();
                            
                            function load<?= $pluralClassEntityName ?>() {
                                apiClientService.select<?= $pluralClassEntityName ?>()
                                    .then(<?= $pluralFieldEntityName ?> => self.<?= $pluralFieldEntityName ?> = <?= $pluralFieldEntityName ?>)
                                    .catch(error => console.error(error));
                            }
                        }
                    }
                }
            })();

            <?php

        });
    }

}
