<?php

namespace CrystalCode\Php\Common\Cruddy;

use CrystalCode\Php\Common\Cruddy\Templates\ApiClientServiceTemplateProviderEntry;
use CrystalCode\Php\Common\Cruddy\Templates\Directives\EditorDirectiveCtrlTemplateProviderEntry;
use CrystalCode\Php\Common\Cruddy\Templates\Directives\EditorDirectiveHtmlTemplateProviderEntry;
use CrystalCode\Php\Common\Cruddy\Templates\Directives\ListingDirectiveCtrlTemplateProviderEntry;
use CrystalCode\Php\Common\Cruddy\Templates\Directives\ListingDirectiveHtmlTemplateProviderEntry;
use CrystalCode\Php\Common\Cruddy\Templates\Directives\ViewerDirectiveCtrlTemplateProviderEntry;
use CrystalCode\Php\Common\Cruddy\Templates\Directives\ViewerDirectiveHtmlTemplateProviderEntry;
use CrystalCode\Php\Common\Cruddy\Templates\States\CreateStateCtrlTemplateProviderEntry;
use CrystalCode\Php\Common\Cruddy\Templates\States\CreateStateHtmlTemplateProviderEntry;
use CrystalCode\Php\Common\Cruddy\Templates\States\DetailStateCtrlTemplateProviderEntry;
use CrystalCode\Php\Common\Cruddy\Templates\States\DetailStateHtmlTemplateProviderEntry;
use CrystalCode\Php\Common\Cruddy\Templates\States\EditDetailStateCtrlTemplateProviderEntry;
use CrystalCode\Php\Common\Cruddy\Templates\States\EditDetailStateHtmlTemplateProviderEntry;
use CrystalCode\Php\Common\Cruddy\Templates\States\RootStateCtrlTemplateProviderEntry;
use CrystalCode\Php\Common\Cruddy\Templates\States\RootStateHtmlTemplateProviderEntry;
use CrystalCode\Php\Common\Cruddy\Templates\States\SelectStateCtrlTemplateProviderEntry;
use CrystalCode\Php\Common\Cruddy\Templates\States\SelectStateHtmlTemplateProviderEntry;
use CrystalCode\Php\Common\Cruddy\Templates\States\ViewDetailStateCtrlTemplateProviderEntry;
use CrystalCode\Php\Common\Cruddy\Templates\States\ViewDetailStateHtmlTemplateProviderEntry;
use CrystalCode\Php\Common\Scaffolding\ExecutorBase;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\DelegateScaffolderProvider;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\DirectoryScaffolderBuilder;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\FileScaffolderBuilder;
use CrystalCode\Php\Common\Scaffolding\Instructions\DebugInstructionHandlerDelegateProvider;
use CrystalCode\Php\Common\Scaffolding\Instructions\InstructionProcessor;
use CrystalCode\Php\Common\Scaffolding\Instructions\InstructionProcessorInterface;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\ScaffolderInterface;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\ScaffolderProviderInterface;
use CrystalCode\Php\Common\Scaffolding\Templates\TemplateProvider;
use CrystalCode\Php\Common\Scaffolding\Templates\TemplateProviderInterface;
use CrystalCode\Php\Common\Scaffolding\Util\Identifier;
use CrystalCode\Php\Common\Templates\DelegateTemplate;

final class CruddyExecutor extends ExecutorBase
{

    /**
     * 
     * {@inheritdoc}
     */
    public function getRootPath(): string
    {
        return 'C:/temp/output';
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getInstructionProcessor(): InstructionProcessorInterface
    {
        return new InstructionProcessor(...[
            // new CreateFileInstructionHandlerDelegateProvider(),
            // new CreateDirectoryInstructionHandlerDelegateProvider(),
            new DebugInstructionHandlerDelegateProvider(),
        ]);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getScaffolderProvider(): ScaffolderProviderInterface
    {
        return new DelegateScaffolderProvider(function () {
            yield DirectoryScaffolderBuilder::create()
                ->withPath('services')
                ->withScaffolders(function () {
                    $entities = $this->getEntities();

                    yield FileScaffolderBuilder::create()
                      ->withPath('apiClientService.js')
                      ->withContents($this->getTemplateProvider(), [
                          'service'  => 'api',
                          'entities' => $entities,
                      ])
                      ->build();
                })
                ->build();

            yield DirectoryScaffolderBuilder::create()
                ->withPath('directives')
                ->withScaffolders(function () {
                    $entities = $this->getEntities();

                    foreach ($entities as $entity) {
                        $entityName = $entity->getName();
                        $singleFieldEntityName = Identifier::getSingleFieldName($entityName);

                        foreach (['listing', 'filters', 'editor', 'viewer'] as $directive) {
                            $singleClassDirectiveName = Identifier::getSingleClassName($directive);

                            yield DirectoryScaffolderBuilder::create()
                              ->withPath("{$singleFieldEntityName}{$singleClassDirectiveName}")
                              ->withScaffolders(function () use ($entity, $directive) {
                                  $entityName = $entity->getName();
                                  $singleFieldEntityName = Identifier::getSingleFieldName($entityName);
                                  $singleClassDirectiveName = Identifier::getSingleClassName($directive);

                                  yield FileScaffolderBuilder::create()
                                    ->withPath("{$singleFieldEntityName}{$singleClassDirectiveName}.js")
                                    ->withContents($this->getTemplateProvider(), [
                                        'type'      => 'ctrl',
                                        'directive' => $directive,
                                        'entity'    => $entity,
                                    ])
                                    ->build();

                                  yield FileScaffolderBuilder::create()
                                    ->withPath("{$singleFieldEntityName}{$singleClassDirectiveName}.html")
                                    ->withContents($this->getTemplateProvider(), [
                                        'type'      => 'html',
                                        'directive' => $directive,
                                        'entity'    => $entity,
                                    ])
                                    ->build();
                              })
                              ->build();
                        }
                    }
                })
                ->build();

            yield DirectoryScaffolderBuilder::create()
                ->withPath('states')
                ->withScaffolders(function () {
                    $entities = $this->getEntities();

                    foreach ($entities as $entity) {
                        $entityName = strtolower($entity->getName());

                        yield DirectoryScaffolderBuilder::create()
                          ->withPath($entityName)
                          ->withScaffolders(function () use ($entity) {
                              $entityName = strtolower($entity->getName());

                              yield FileScaffolderBuilder::create()
                                ->withPath("{$entityName}.js")
                                ->withContents($this->getTemplateProvider(), [
                                    'type'   => 'ctrl',
                                    'state'  => 'root',
                                    'entity' => $entity,
                                ])
                                ->build();

                              yield FileScaffolderBuilder::create()
                                ->withPath("{$entityName}.html")
                                ->withContents($this->getTemplateProvider(), [
                                    'type'   => 'html',
                                    'state'  => 'root',
                                    'entity' => $entity,
                                ])
                                ->build();

                              yield FileScaffolderBuilder::create()
                                ->withPath("{$entityName}.scss")
                                ->withContents($this->getTemplateProvider(), [
                                    'type'   => 'scss',
                                    'state'  => 'root',
                                    'entity' => $entity,
                                ])
                                ->build();

                              foreach (['select', 'create', 'detail'] as $state) {
                                  yield DirectoryScaffolderBuilder::create()
                                    ->withPath($state)
                                    ->withScaffolders(function () use ($entity, $state) {

                                        yield FileScaffolderBuilder::create()
                                          ->withPath("{$state}.js")
                                          ->withContents($this->getTemplateProvider(), [
                                              'type'   => 'ctrl',
                                              'state'  => $state,
                                              'entity' => $entity,
                                          ])
                                          ->build();

                                        yield FileScaffolderBuilder::create()
                                          ->withPath("{$state}.html")
                                          ->withContents($this->getTemplateProvider(), [
                                              'type'   => 'html',
                                              'state'  => $state,
                                              'entity' => $entity,
                                          ])
                                          ->build();

                                        yield FileScaffolderBuilder::create()
                                          ->withPath("{$state}.scss")
                                          ->withContents($this->getTemplateProvider(), [
                                              'type'   => 'scss',
                                              'state'  => $state,
                                              'entity' => $entity,
                                          ])
                                          ->build();

                                        if ($state === 'detail') {
                                            foreach (['view', 'edit'] as $state) {
                                                yield DirectoryScaffolderBuilder::create()
                                                  ->withPath($state)
                                                  ->withScaffolders(function () use ($entity, $state) {

                                                      yield FileScaffolderBuilder::create()
                                                        ->withPath("{$state}.js")
                                                        ->withContents($this->getTemplateProvider(), [
                                                            'type'   => 'ctrl',
                                                            'state'  => $state,
                                                            'entity' => $entity,
                                                        ])
                                                        ->build();

                                                      yield FileScaffolderBuilder::create()
                                                        ->withPath("{$state}.html")
                                                        ->withContents($this->getTemplateProvider(), [
                                                            'type'   => 'html',
                                                            'state'  => $state,
                                                            'entity' => $entity,
                                                        ])
                                                        ->build();

                                                      yield FileScaffolderBuilder::create()
                                                        ->withPath("{$state}.scss")
                                                        ->withContents($this->getTemplateProvider(), [
                                                            'type'   => 'scss',
                                                            'state'  => $state,
                                                            'entity' => $entity,
                                                        ])
                                                        ->build();
                                                  })
                                                  ->build();
                                            }
                                        }
                                    })
                                    ->build();
                              }
                          })
                          ->build();
                    }
                })
                ->build();
        });
    }

    /**
     * 
     * @return iterable|ScaffolderInterface[]
     */
    public function getScaffolders(): iterable
    {
        
    }

    /**
     * 
     * @retEntityInterfacetityInterface[]
     */
    private function getEntities(): iterable
    {
        yield new Entity('Offer', ...[
              new Property('id'),
              new Property('name'),
              new Property('description'),
        ]);
        yield new Entity('Partner');
        yield new Entity('Promotion');
    }

    /**
     * 
     * @return TemplateProviderInterface
     */
    private function getTemplateProvider(): TemplateProviderInterface
    {
        $defaultTemplate = new DelegateTemplate(function () {
            echo '// @TODO';
        });

        return new TemplateProvider($defaultTemplate, ...[
            new RootStateCtrlTemplateProviderEntry(),
            new RootStateHtmlTemplateProviderEntry(),
            new SelectStateCtrlTemplateProviderEntry(),
            new SelectStateHtmlTemplateProviderEntry(),
            new CreateStateCtrlTemplateProviderEntry(),
            new CreateStateHtmlTemplateProviderEntry(),
            new DetailStateCtrlTemplateProviderEntry(),
            new DetailStateHtmlTemplateProviderEntry(),
            new ViewDetailStateCtrlTemplateProviderEntry(),
            new ViewDetailStateHtmlTemplateProviderEntry(),
            new EditDetailStateCtrlTemplateProviderEntry(),
            new EditDetailStateHtmlTemplateProviderEntry(),
            new ApiClientServiceTemplateProviderEntry(),
            new ListingDirectiveCtrlTemplateProviderEntry(),
            new ListingDirectiveHtmlTemplateProviderEntry(),
            new EditorDirectiveCtrlTemplateProviderEntry(),
            new EditorDirectiveHtmlTemplateProviderEntry(),
            new ViewerDirectiveCtrlTemplateProviderEntry(),
            new ViewerDirectiveHtmlTemplateProviderEntry(),
        ]);
    }

}
