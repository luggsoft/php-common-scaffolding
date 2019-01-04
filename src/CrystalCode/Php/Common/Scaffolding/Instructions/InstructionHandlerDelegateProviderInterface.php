<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

interface InstructionHandlerDelegateProviderInterface
{

    /**
     * 
     * @return bool
     */
    function canHandle(InstructionInterface $instruction): bool;

    /**
     * 
     * @return callable
     */
    function getHandlerDelegate(): callable;

}
