<?php

namespace CrystalCode\Php\Common\Scaffolding;

use CrystalCode\Php\Common\Collections\Collection;
use CrystalCode\Php\Common\Injectors\AliasDefinition;
use CrystalCode\Php\Common\Injectors\InjectorInterface;
use CrystalCode\Php\Common\Injectors\InstanceDefinition;
use CrystalCode\Php\Common\Scaffolding\Instructions\InstructionInterface;
use Exception;

abstract class ItemProcessorBase implements ItemProcessorInterface
{

    /**
     *
     * @var InjectorInterface
     */
    private $injector;

    /**
     *
     * @var callable[]
     */
    private $handlers = [];

    /**
     * 
     * @param InjectorInterface $injector
     * @param callable[] $handlers
     */
    public function __construct(InjectorInterface $injector, $handlers = [])
    {
        $this->injector = $injector;
        $this->addItemHandlers($handlers + [
            FileItemBase::class => [$this, 'handleFileItem'],
            DirectoryItemBase::class => [$this, 'handleDirectoryItem'],
        ]);
    }

    /**
     * 
     * @param callable[] $handlers
     * @return void
     */
    final public function addItemHandlers($handlers)
    {
        foreach (Collection::create($handlers) as $className => $handler) {
            $this->addItemHandler($className, $handler);
        }
    }

    /**
     * 
     * @param string $className
     * @param callable $handler
     * @return void
     */
    final public function addItemHandler($className, callable $handler)
    {
        $this->handlers[(string) $className] = function (ItemInterface $item) use ($className, $handler) {
            $definitions = [
                new InstanceDefinition($item),
                new AliasDefinition($className, get_class($item)),
            ];
            $this->injector->withDefinitions($definitions)->call($handler);
            // $instructions = $this->injector->withDefinitions($definitions)->call($handler);
            // foreach (Collection::create($instructions) as $instruction) {
            //     yield $instruction;
            // }
        };
    }

    /**
     * 
     * @param ItemInterface $item
     * @return mixed
     * @throws Exception
     */
    final public function processItem(ItemInterface $item)
    {
        $handler = $this->getItemHandler($item);
        call_user_func($handler, $item);
        // $instructions = call_user_func($handler, $item);
        // foreach (Collection::create($instructions) as $instruction) {
        //     yield $instruction;
        // }
    }

    /**
     * 
     * @param string $className
     * @return callable
     * @throws Exception
     */
    final public function getItemHandler(ItemInterface $item)
    {
        $className = get_class($item);
        while (true) {
            if (isset($this->handlers[$className])) {
                return $this->handlers[$className];
            }
            $className = get_parent_class($className);
            if (empty($className)) {
                throw new Exception();
            }
        }
    }

    /**
     * 
     * @param FileItemBase $fileItem
     * @return void
     */
    abstract protected function handleFileItem(FileItemBase $fileItem);

    /**
     * 
     * @param DirectoryItemBase $directoryItem
     * @return void
     */
    abstract protected function handleDirectoryItem(DirectoryItemBase $directoryItem);

}
