<?php

namespace CrystalCode\Php\Common\Scaffolding\Templates;

use CrystalCode\Php\Common\Templates\TemplateInterface;

final class DelegateTemplateProviderEntry extends TemplateProviderEntryBase
{

    /**
     *
     * @var callable
     */
    private $getTemplateDelegate;

    /**
     *
     * @var callable
     */
    private $getApplicabilityDelegate;

    /**
     * 
     * @param callable $getTemplateDelegate
     * @param callable $getApplicabilityDelegate
     */
    public function __construct(callable $getTemplateDelegate, callable $getApplicabilityDelegate)
    {
        $this->getTemplateDelegate = $getTemplateDelegate;
        $this->getApplicabilityDelegate = $getApplicabilityDelegate;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getTemplate($values): TemplateInterface
    {
        return call_user_func($this->getTemplateDelegate, $values);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getApplicability($values): int
    {
        return (int) call_user_func($this->getApplicabilityDelegate, $values);
    }

}
