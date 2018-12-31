<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Templates;

final class TemplateProvider extends TemplateProviderBase
{

    /**
     *
     * @var array|TemplateProviderEntryInterface[]
     */
    private $templateProviderEntries = [];

    /**
     * 
     * @param iterable|TemplateProviderEntryInterface[] $templateProviderEntries
     */
    public function __construct(TemplateProviderEntryInterface ...$templateProviderEntries)
    {
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
