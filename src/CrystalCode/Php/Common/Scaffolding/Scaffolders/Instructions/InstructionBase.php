<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions;

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
