<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Templates;

use CrystalCode\Php\Common\Templates\TemplateInterface;

final class TemplateProvider extends TemplateProviderBase
{

    /**
     *
     * @var array|TemplateProviderEntryInterface[]
     */
    private $templateProviderEntries = [];

    /**
     * 
     * @param TemplateInterface $defaultTemplate
     * @param iterable|TemplateProviderEntryInterface[] $templateProviderEntries
     */
    public function __construct(?TemplateInterface $defaultTemplate, TemplateProviderEntryInterface ...$templateProviderEntries)
    {
        parent::__construct($defaultTemplate);
        $this->templateProviderEntries = $templateProviderEntries;
    }

    /**
     * 
     * {@inheritdoc}
     */
    protected function getTemplateProviderEntries(): iterable
    {
        return $this->templateProviderEntries;
    }

}
