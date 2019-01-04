<?php

namespace CrystalCode\Php\Common\Cruddy\Templates\Directives;

use CrystalCode\Php\Common\Cruddy\EntityInterface;
use CrystalCode\Php\Common\Scaffolding\Templates\TemplateProviderEntryBase;
use CrystalCode\Php\Common\Scaffolding\Util\Identifier;
use CrystalCode\Php\Common\Templates\DelegateTemplate;
use CrystalCode\Php\Common\Templates\TemplateInterface;

final class ViewerDirectiveCtrlTemplateProviderEntry extends TemplateProviderEntryBase
{

    /**
     * 
     * {@inheritdoc}
     */
    public function getApplicability($values): int
    {
        $total = 0;

        if ($values->entity instanceof EntityInterface) {
            if ($values->directive === 'viewer' && $values->type === 'ctrl') {
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
                
                angular.module('cruddy').directive('<?= $singleFieldEntityName ?>Viewer', [directiveFactory]);
                
                function directiveFactory() {
                    return _.defaults(this, {
                        scope: {
                            <?= $singleFieldEntityName ?>: '<',
                            onEvent: '&?',
                        },
                        templateUrl: 'src/cruddy/directives/<?= $singleFieldEntityName ?>Viewer/<?= $singleFieldEntityName ?>Viewer.html',
                        controller: ['$scope', '$state', controller],
                        bindToController: true,
                        controllerAs: 'self',
                    });
                    
                    function controller($scope, $state) {
                        const self = _.defaults(this, {
                            <?= $singleFieldEntityName ?>: {},
                            onEvent: undefined,
                        });
                        
                        function triggerEvent(event) {
                            if (_.isFunction(self.onEvent)) {
                                self.onEvent(event);
                            }
                        }
                    }
                }
            })();
            
            <?php
            
        });
    }

}
