<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Templates;

use CrystalCode\Php\Common\Templates\TemplateInterface;

final class DelegateTemplateProvider extends TemplateProviderBase
{

    /**
     *
     * @var callable
     */
    private $getTemplateProviderEntriesDelegate = [];

    /**
     * 
     * @param TemplateInterface $defaultTemplate
     * @param callable $getTemplateProviderEntriesDelegate
     */
    public function __construct(?TemplateInterface $defaultTemplate, callable $getTemplateProviderEntriesDelegate)
    {
        parent::__construct($defaultTemplate);
        $this->getTemplateProviderEntriesDelegate = $getTemplateProviderEntriesDelegate;
    }

    /**
     * 
     * {@inheritdoc}
     */
    protected function getTemplateProviderEntries(): iterable
    {
        foreach (call_user_func($this->getTemplateProviderEntriesDelegate) as $templateProviderEntry) {
            yield $templateProviderEntry;
        }
    }

}
