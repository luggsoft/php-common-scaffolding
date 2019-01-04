<?php

namespace CrystalCode\Php\Common\Scaffolding\Templates;

use CrystalCode\Php\Common\Collections\Collector;
use CrystalCode\Php\Common\Templates\TemplateInterface;
use CrystalCode\Php\Common\ValuesObject;

abstract class TemplateProviderBase implements TemplateProviderInterface
{

    /**
     *
     * @var TemplateInterface
     */
    private $defaultTemplate;

    /**
     * 
     * @param TemplateInterface $defaultTemplate
     */
    public function __construct(TemplateInterface $defaultTemplate = null)
    {
        $this->defaultTemplate = $defaultTemplate;
    }

    /**
     * 
     * {@inheritdoc}
     */
    final public function getTemplate($values): TemplateInterface
    {
        $valuesObject = ValuesObject::create($values);
        $templateProviderEntries = $this->getTemplateProviderEntries();
        $templateProviderEntry = Collector::create($templateProviderEntries)
          ->filter(function (TemplateProviderEntryInterface $templateProviderEntry) use ($valuesObject) {
              return $templateProviderEntry->getApplicability($valuesObject) > 0;
          })
          ->max(function (TemplateProviderEntryInterface $templateProviderEntry) use ($valuesObject) {
            return $templateProviderEntry->getApplicability($valuesObject);
        });

        if ($templateProviderEntry === null) {
            if ($this->defaultTemplate !== null) {
                // Logger::log('Using default template!', print_r($values, true));
                return $this->defaultTemplate;
            }

            throw new TemplateProviderException();
        }

        return $templateProviderEntry->getTemplate($valuesObject);
    }

    /**
     * 
     * @return iterable|TemplateProviderEntryInterface[]
     */
    abstract protected function getTemplateProviderEntries(): iterable;

}
