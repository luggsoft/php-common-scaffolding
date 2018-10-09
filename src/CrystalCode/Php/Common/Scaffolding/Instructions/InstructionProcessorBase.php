<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

use CrystalCode\Php\Common\Collections\Collection;
use CrystalCode\Php\Common\Injectors\InjectorInterface;
use CrystalCode\Php\Common\Injectors\InstanceDefinition;
use Exception;

abstract class InstructionProcessorBase implements InstructionProcessorInterface
{

    /**
     *
     * @var InjectorInterface
     */
    private $injector;

    /**
     *
     * @var array|callable[]
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
        $this->addInstructionHandler(CompositeInstruction::class, [$this, 'handleCompositeInstruction']);
        $this->addInstructionHandlers($handlers);
    }

    /**
     * 
     * {@inheritdoc}
     */
    final public function processInstruction(InstructionInterface $instruction)
    {
        $className = get_class($instruction);
        if (isset($this->handlers[$className])) {
            $handler = $this->handlers[$className];
            return call_user_func($handler, $instruction);
        }
        throw new Exception();
    }

    /**
     * 
     * @param callable[] $handlers
     */
    final public function addInstructionHandlers($handlers)
    {
        foreach (Collection::create($handlers) as $className => $handler) {
            $this->addInstructionHandler($className, $handler);
        }
    }

    /**
     * 
     * @param string $className
     * @param callable $handler
     * @return void
     * @throws Exception
     */
    final public function addInstructionHandler($className, callable $handler)
    {
        if (is_subclass_of($className, InstructionInterface::class) === false) {
            throw new Exception();
        }
        $this->handlers[(string) $className] = function (InstructionInterface $instruction) use ($handler) {
            $definition = new InstanceDefinition($instruction);
            return (bool) $this->injector->withDefinition($definition)->call($handler);
        };
    }

    /**
     * 
     * @param CompositeInstruction $compositeInstruction
     * @return bool
     */
    final public function handleCompositeInstruction(CompositeInstruction $compositeInstruction)
    {
        foreach ($compositeInstruction->getInstructions() as $instruction) {
            if ($this->processInstruction($instruction)) {
                continue;
            }
            return false;
        }
        return true;
    }

}
