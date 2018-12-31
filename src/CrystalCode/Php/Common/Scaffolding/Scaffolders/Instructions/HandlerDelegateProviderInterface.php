<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions;

interface HandlerDelegateProviderInterface
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
