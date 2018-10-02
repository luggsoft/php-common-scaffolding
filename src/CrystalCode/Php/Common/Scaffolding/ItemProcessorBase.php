<?php

namespace CrystalCode\Php\Common\Scaffolding;

use CrystalCode\Php\Common\Collections\Collection;
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
            DefaultFileItem::class => [$this, 'handleFileItem'],
            DefaultDirectoryItem::class => [$this, 'handleDirectoryItem'],
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
        $this->handlers[(string) $className] = function (ItemInterface $item) use ($handler) {
            $definition = new InstanceDefinition($item);
            $instructions = $this->injector->withDefinition($definition)->call($handler);
            foreach (Collection::create($instructions) as $instruction) {
                yield $instruction;
            }
        };
    }

    /**
     * 
     * @param ItemInterface $item
     * @return InstructionInterface[]
     * @throws Exception
     */
    final public function processItem(ItemInterface $item)
    {
        $className = get_class($item);
        if (isset($this->handlers[$className])) {
            $handler = $this->handlers[$className];
            $instructions = call_user_func($handler, $item);
            foreach (Collection::create($instructions) as $instruction) {
                yield $instruction;
            }
            return;
        }
        throw new Exception();
    }

    /**
     * 
     * @param DefaultFileItem $fileItem
     * @return InstructionInterface[]
     */
    abstract protected function handleFileItem(DefaultFileItem $fileItem);

    /**
     * 
     * @param DefaultDirectoryItem $directoryItem
     * @return InstructionInterface[]
     */
    abstract protected function handleDirectoryItem(DefaultDirectoryItem $directoryItem);

}
