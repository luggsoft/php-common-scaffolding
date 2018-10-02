<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

use CrystalCode\Php\Common\Collections\Collection;

final class CompositeInstruction extends InstructionBase
{

    /**
     *
     * @var array|InstructionInterface[]
     */
    private $instructions = [];

    /**
     * 
     * @param InstructionInterface[] $instructions
     */
    public function __construct($instructions)
    {
        $this->addInstructions($instructions);
    }

    /**
     * 
     * @param InstructionInterface[] $instructions
     * @return void
     */
    public function addInstructions($instructions)
    {
        foreach (Collection::create($instructions) as $instruction) {
            $this->addInstruction($instruction);
        }
    }

    /**
     * 
     * @param InstructionInterface $instruction
     * @return void
     */
    public function addInstruction(InstructionInterface $instruction)
    {
        $this->instructions[] = $instruction;
    }

    /**
     * 
     * @return array|InstructionInterface[]
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * 
     * @return string
     */
    public function toString()
    {
        ob_start();
        var_dump($this);
        return (string) ob_get_clean();
    }

}
