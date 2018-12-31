<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders\Templates;

use CrystalCode\Php\Common\Collections\Collector;
use CrystalCode\Php\Common\Templates\TemplateInterface;

abstract class TemplateProviderBase implements TemplateProviderInterface
{

    /**
     * 
     * {@inheritdoc}
     */
    final public function getTemplate($values): TemplateInterface
    {
        if (!($values instanceof TemplateProviderValues)) {
            $values = TemplateProviderValues::create($values);
        }

        $templateProviderEntries = $this->getTemplateProviderEntries();

        $templateProviderEntry = Collector::create($templateProviderEntries)
          ->max(function (TemplateProviderEntryInterface $templateProviderEntry) use ($values) {
            return $templateProviderEntry->getApplicability($values);
        });

        if ($templateProviderEntry === null) {
            throw new TemplateProviderException();
        }

        return $templateProviderEntry->getTemplate($values);
    }

    /**
     * 
     * @return iterable|TemplateProviderEntryInterface[]
     */
    abstract protected function getTemplateProviderEntries(): iterable;

}
