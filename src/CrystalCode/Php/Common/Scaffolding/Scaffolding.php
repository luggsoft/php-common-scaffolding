<?php

namespace CrystalCode\Php\Common\Scaffolding;

use CrystalCode\Php\Common\Collections\Collection;
use CrystalCode\Php\Common\Injectors\Injector;
use CrystalCode\Php\Common\Injectors\InjectorInterface;
use CrystalCode\Php\Common\Scaffolding\Instructions\ExportInstructionProcessor;
use CrystalCode\Php\Common\Scaffolding\Instructions\InstructionProcessorInterface;
use CrystalCode\Php\Common\Scaffolding\Templates\TemplateFileItem;

require_once sprintf('%s/../../../../../vendor/autoload.php', __DIR__);

interface ScaffolderInterface
{

    /**
     * 
     * @return void
     */
    function scaffold();

}

abstract class ScaffolderBase implements ScaffolderInterface
{

    /**
     * 
     * @return void
     */
    final public function scaffold()
    {
        $items = $this->getItems();
        $itemProcessor = $this->getItemProcessor();
        $instructionProcessor = $this->getInstructionProcessor();
        foreach (Collection::create($items) as $item) {
            $instructions = $itemProcessor->processItem($item);
            foreach (Collection::create($instructions) as $instruction) {
                $instructionProcessor->processInstruction($instruction);
            }
        }
    }

    /**
     * 
     * @return ItemInterface[]
     */
    abstract public function getItems();

    /**
     * 
     * @return ItemProcessorInterface
     */
    abstract public function getItemProcessor();

    /**
     * 
     * @return InstructionProcessorInterface
     */
    abstract public function getInstructionProcessor();

}

final class DefaultScaffolder extends ScaffolderBase
{

    /**
     *
     * @var InjectorInterface
     */
    private $injector;

    /**
     * 
     * @param InjectorInterface $injector
     */
    public function __construct(InjectorInterface $injector)
    {
        $this->injector = $injector;
    }

    /**
     * 
     * @return ItemInterface[]
     */
    public function getItems()
    {
        yield new DefaultDirectoryItem('Templates', function () {
            yield new DefaultDirectoryItem('Public', function () {
                yield new TemplateFileItem('PublicStateCtrlTemplate', 'php');
                yield new TemplateFileItem('PublicStateHtmlTemplate', 'php');
                yield new DefaultDirectoryItem('About', function () {
                    yield new TemplateFileItem('AboutStateCtrlTemplate', 'php');
                    yield new TemplateFileItem('AboutStateHtmlTemplate', 'php');
                });
                yield new DefaultDirectoryItem('Login', function () {
                    yield new TemplateFileItem('LoginStateCtrlTemplate', 'php');
                    yield new TemplateFileItem('LoginStateHtmlTemplate', 'php');
                });
            });
            yield new DefaultDirectoryItem('Private', function () {
                yield new TemplateFileItem('PrivateStateCtrlTemplate', 'php');
                yield new TemplateFileItem('PrivateStateHtmlTemplate', 'php');
                yield new DefaultDirectoryItem('Management', function () {
                    yield new TemplateFileItem('ManagementStateCtrlTemplate', 'php');
                    yield new TemplateFileItem('ManagementStateHtmlTemplate', 'php');
                    yield new DefaultDirectoryItem('Dashboard', function () {
                        yield new TemplateFileItem('DashboardStateCtrlTemplate', 'php');
                        yield new TemplateFileItem('DashboardStateHtmlTemplate', 'php');
                    });
                    yield new DefaultDirectoryItem('Entity', function () {
                        yield new TemplateFileItem('EntityStateCtrlTemplate', 'php');
                        yield new TemplateFileItem('EntityStateHtmlTemplate', 'php');
                        yield new DefaultDirectoryItem('Select', function () {
                            yield new TemplateFileItem('SelectStateCtrlTemplate', 'php');
                            yield new TemplateFileItem('SelectStateHtmlTemplate', 'php');
                        });
                        yield new DefaultDirectoryItem('Create', function () {
                            yield new TemplateFileItem('CreateStateCtrlTemplate', 'php');
                            yield new TemplateFileItem('CreateStateHtmlTemplate', 'php');
                        });
                        yield new DefaultDirectoryItem('Detail', function () {
                            yield new TemplateFileItem('DetailStateCtrlTemplate', 'php');
                            yield new TemplateFileItem('DetailStateHtmlTemplate', 'php');
                            yield new DefaultDirectoryItem('View', function () {
                                yield new TemplateFileItem('ViewStateCtrlTemplate', 'php');
                                yield new TemplateFileItem('ViewStateHtmlTemplate', 'php');
                            });
                            yield new DefaultDirectoryItem('Edit', function () {
                                yield new TemplateFileItem('EditStateCtrlTemplate', 'php');
                                yield new TemplateFileItem('EditStateHtmlTemplate', 'php');
                            });
                        });
                    });
                    yield new DefaultDirectoryItem('Account', function () {
                        yield new TemplateFileItem('AccountStateCtrlTemplate', 'php');
                        yield new TemplateFileItem('AccountStateHtmlTemplate', 'php');
                        yield new DefaultDirectoryItem('Profile', function () {
                            yield new TemplateFileItem('ProfileStateCtrlTemplate', 'php');
                            yield new TemplateFileItem('ProfileStateHtmlTemplate', 'php');
                        });
                        yield new DefaultDirectoryItem('Settings', function () {
                            yield new TemplateFileItem('SettingsStateCtrlTemplate', 'php');
                            yield new TemplateFileItem('SettingsStateHtmlTemplate', 'php');
                        });
                    });
                });
            });
        });
    }

    /**
     * 
     * @return DefaultItemProcessor
     */
    public function getItemProcessor()
    {
        return new DefaultItemProcessor($this->injector);
    }

    /**
     * 
     * @return InstructionProcessorInterface
     */
    public function getInstructionProcessor()
    {
        return new ExportInstructionProcessor($this->injector);
    }

}

function main()
{
    $injector = new Injector();
    $scaffolder = new DefaultScaffolder($injector);
    $scaffolder->scaffold();
    ;
}

main();
