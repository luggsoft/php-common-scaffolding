<?php

namespace CrystalCode\Php\Common\Scaffolding\Templates;

use CrystalCode\Php\Common\ExceptionBase;
use Throwable;

class TemplateProviderException extends ExceptionBase
{

    /**
     * 
     * @param string $message
     * @param int $code
     * @param Throwable $previous
     */
    public function __construct(string $message = null, int $code = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
