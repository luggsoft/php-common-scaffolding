<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

abstract class InstructionBase implements InstructionInterface
{

    /**
     * 
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return static::class;
    }

}
