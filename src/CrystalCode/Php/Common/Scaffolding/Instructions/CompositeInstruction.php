<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

use CrystalCode\Php\Common\Json\JsonValuesGetterInterface;
use CrystalCode\Php\Common\Json\JsonValuesSetterInterface;

final class CompositeInstruction extends InstructionBase implements JsonValuesGetterInterface, JsonValuesSetterInterface
{

    /**
     *
     * @var array|InstructionInterface[]
     */
    private $instructions = [];

    /**
     * 
     * @param iterable|InstructionInterface[] $instructions
     */
    public function __construct(InstructionInterface ...$instructions)
    {
        $this->instructions = $instructions;
    }

    /**
     * 
     * @return iterable|InstructionInterface[]
     */
    public function getInstructions(): iterable
    {
        return $this->instructions;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getJsonValues(): object
    {
        return (object) [
              'instructions' => $this->instructions,
        ];
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function setJsonValues(object $jsonValues): void
    {
        $this->instructions = (array) $jsonValues->instructions;
    }

}
