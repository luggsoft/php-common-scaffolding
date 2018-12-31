<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions;

use Exception;

final class Processor implements ProcessorInterface
{

    /**
     *
     * @var array|HandlerDelegateProviderInterface[]
     */
    private $handlerDelegateProviders = [];

    /**
     * 
     * @param iterable|HandlerDelegateProviderInterface[] $handlerDelegateProviders
     */
    public function __construct(HandlerDelegateProviderInterface ...$handlerDelegateProviders)
    {
        $this->handlerDelegateProviders = $handlerDelegateProviders;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function processInstructions(iterable $instructions, ProcessorContext $processorContext = null): void
    {
        if ($processorContext === null) {
            $processorContext = new ProcessorContext();
        }

        foreach ($instructions as $instruction) {
            if ($this->processInstruction($instruction, $processorContext)) {
                continue;
            }

            throw new Exception('Unhandled instruction');
        }
    }

    /**
     * 
     * @param InstructionInterface $instruction
     * @param ProcessorContext $processorContext
     * @return bool
     * @throws Exception
     */
    public function processInstruction(InstructionInterface $instruction, ProcessorContext $processorContext = null): bool
    {
        if ($processorContext === null) {
            $processorContext = new ProcessorContext();
        }

        $isHandled = false;

        foreach ($this->getHandlerDelegateProviders($instruction) as $handlerDelegateProvider) {
            $handlerDelegate = $handlerDelegateProvider->getHandlerDelegate();

            try {
                call_user_func($handlerDelegate, $instruction, $processorContext, $this);
                $isHandled = true;
            }
            catch (Exception $exception) {
                throw new Exception('Unhandled instruction', 0, $exception);
            }
        }

        return $isHandled;
    }

    /**
     * 
     * @param InstructionInterface $instruction
     * @return iterable|HandlerDelegateProviderInterface[]
     */
    public function getHandlerDelegateProviders(InstructionInterface $instruction): iterable
    {
        foreach ($this->handlerDelegateProviders as $handlerDelgateProvider) {
            if ($handlerDelgateProvider->canHandle($instruction)) {
                yield $handlerDelgateProvider;
            }
        }
    }

}
