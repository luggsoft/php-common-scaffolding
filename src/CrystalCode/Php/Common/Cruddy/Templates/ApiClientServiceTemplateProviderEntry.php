<?php

namespace CrystalCode\Php\Common\Cruddy\Templates;

use CrystalCode\Php\Common\Scaffolding\Templates\TemplateProviderEntryBase;
use CrystalCode\Php\Common\Scaffolding\Util\Identifier;
use CrystalCode\Php\Common\Templates\DelegateTemplate;
use CrystalCode\Php\Common\Templates\TemplateInterface;

final class ApiClientServiceTemplateProviderEntry extends TemplateProviderEntryBase
{

    /**
     * 
     * {@inheritdoc}
     */
    public function getApplicability($values): int
    {
        $total = 0;

        if ($values->service === 'api') {
            $total += 10;
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

            $entities = [];

            foreach ($values->entities as $entity) {
                $entities[] = $entity;
            }

            ?>

            (() => {
                'use strict';
                
                angular.module('cruddy').service('apiClientService', ['$http', serviceFactory]);
                
                function serviceFactory() {
                    return new apiClientService();
                    
                    function apiClientService() {
                        return _.defaults(this, {

                            <?php foreach ($entities as $entity): ?>

                                <?php

                                $entityName = $entity->getName();
                                $singleFieldEntityName = Identifier::getSingleFieldName($entityName);
                                $singleClassEntityName = Identifier::getSingleClassName($entityName);
                                $pluralClassEntityName = Identifier::getPluralClassName($entityName);

                                ?>

                                select<?= $pluralClassEntityName ?>: select<?= $pluralClassEntityName ?>,
                                select<?= $singleClassEntityName ?>ById: select<?= $singleClassEntityName ?>ById,
                                create<?= $singleClassEntityName ?>: create<?= $singleClassEntityName ?>,
                                update<?= $singleClassEntityName ?>: update<?= $singleClassEntityName ?>,
                                
                            <?php endforeach; ?>

                        });
                        
                        <?php foreach ($entities as $entity): ?>

                            <?php

                            $entityName = $entity->getName();
                            $singleFieldEntityName = Identifier::getSingleFieldName($entityName);
                            $singleClassEntityName = Identifier::getSingleClassName($entityName);
                            $pluralClassEntityName = Identifier::getPluralClassName($entityName);

                            ?>

                            function select<?= $pluralClassEntityName ?>() {
                                // @TODO
                            }

                            function select<?= $singleClassEntityName ?>ById(id) {
                                // @TODO
                            }

                            function create<?= $singleClassEntityName ?>ById(<?= $singleFieldEntityName ?>) {
                                // @TODO
                            }

                            function update<?= $singleClassEntityName ?>ById(<?= $singleFieldEntityName ?>) {
                                // @TODO
                            }

                        <?php endforeach; ?>

                    }
                }
            })();

            <?php

        });
    }

}
