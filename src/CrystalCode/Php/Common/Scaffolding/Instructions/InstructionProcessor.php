<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

use Exception;

final class InstructionProcessor extends InstructionProcessorBase
{

    /**
     *
     * @var array|InstructionHandlerDelegateProviderInterface[]
     */
    private $instructionHandlerDelegateProviders = [];

    /**
     * 
     * @param iterable|InstructionHandlerDelegateProviderInterface[] $instructionHandlerDelegateProviders
     */
    public function __construct(InstructionHandlerDelegateProviderInterface ...$instructionHandlerDelegateProviders)
    {
        $this->instructionHandlerDelegateProviders = $instructionHandlerDelegateProviders;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function processInstruction(InstructionInterface $instruction, InstructionProcessorContext $instructionProcessorContext = null): bool
    {
        if ($instructionProcessorContext === null) {
            $instructionProcessorContext = new InstructionProcessorContext();
        }

        $isHandled = false;

        foreach ($this->getHandlerDelegateProviders($instruction) as $instructionHandlerDelegateProvider) {
            $handlerDelegate = $instructionHandlerDelegateProvider->getHandlerDelegate();

            try {
                call_user_func($handlerDelegate, $instruction, $instructionProcessorContext, $this);
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
     * @return iterable|InstructionHandlerDelegateProviderInterface[]
     */
    public function getHandlerDelegateProviders(InstructionInterface $instruction): iterable
    {
        foreach ($this->instructionHandlerDelegateProviders as $instructionHandlerDelegateProvider) {
            if ($instructionHandlerDelegateProvider->canHandle($instruction)) {
                yield $instructionHandlerDelegateProvider;
            }
        }
    }

}
