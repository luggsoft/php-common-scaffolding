<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders;

use CrystalCode\Php\Common\Scaffolding\Scaffolders\Templates\TemplateProviderInterface;

final class TemplateContentsProvider implements ContentsProviderInterface
{

    /**
     *
     * @var TemplateProviderInterface
     */
    private static $defaultTemplateProvider;

    /**
     * 
     * @param TemplateProviderInterface $templateProvider
     * @return void
     */
    public static function setDefaultTemplateProvider(TemplateProviderInterface $templateProvider): void
    {
        self::$defaultTemplateProvider = $templateProvider;
    }

    /**
     * 
     * @param mixed $values
     * @return TemplateContentsProvider
     */
    public static function create($values = []): TemplateContentsProvider
    {
        return new TemplateContentsProvider(self::$defaultTemplateProvider, $values);
    }

    /**
     *
     * @var TemplateProviderInterface
     */
    private $templateProvider;

    /**
     *
     * @var mixed
     */
    private $values;

    /**
     * 
     * @param TemplateProviderInterface $templateProvider
     * @param mixed $values
     */
    public function __construct(TemplateProviderInterface $templateProvider, $values = [])
    {
        $this->templateProvider = $templateProvider;
        $this->values = $values;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getContents(): string
    {
        $this->templateProvider->getTemplate($this->values);
    }

}
