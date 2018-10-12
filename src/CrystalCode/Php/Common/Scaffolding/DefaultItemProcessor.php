<?php

namespace CrystalCode\Php\Common\Scaffolding;

use CrystalCode\Php\Common\Collections\Collection;
use CrystalCode\Php\Common\Injectors\InjectorInterface;
use CrystalCode\Php\Common\Scaffolding\Instructions\CreateDirectoryInstruction;
use CrystalCode\Php\Common\Scaffolding\Instructions\CreateFileInstruction;
use CrystalCode\Php\Common\Scaffolding\Instructions\InstructionInterface;
use CrystalCode\Php\Common\Templates\DefaultTemplateRenderer;
use CrystalCode\Php\Common\Templates\TemplateRendererInterface;

final class DefaultItemProcessor extends ItemProcessorBase
{

    /**
     *
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    /**
     *
     * @var array|InstructionInterface[]
     */
    private $instructions = [];

    /**
     * 
     * @param InjectorInterface $injector
     * @param callable[] $handlers
     * @param TemplateRendererInterface $templateRenderer
     */
    public function __construct(InjectorInterface $injector, $handlers = [], TemplateRendererInterface $templateRenderer = null)
    {
        parent::__construct($injector, $handlers);
        if ($templateRenderer === null) {
            $templateRenderer = $injector->create(DefaultTemplateRenderer::class);
        }
        $this->templateRenderer = $templateRenderer;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function handleFileItem(FileItemBase $fileItem)
    {
        $template = $fileItem->getTemplate();
        $ancestorItems = $fileItem->getAncestorItems(true);
        $this->instructions[] = new CreateFileInstruction([
            'path' => vsprintf('%s.%s', [
                $this->getPath($ancestorItems),
                $fileItem->getExtension(),
            ]),
            'data' => $this->templateRenderer->renderTemplate($template),
        ]);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function handleDirectoryItem(DirectoryItemBase $directoryItem)
    {
        $ancestorItems = $directoryItem->getAncestorItems(true);
        $this->instructions[] = new CreateDirectoryInstruction([
            'path' => $this->getPath($ancestorItems),
        ]);
        foreach ($directoryItem->getChildItems() as $childItem) {
            $this->processItem($childItem);
        }
    }

    /**
     * 
     * @return array|InstructionInterface[]
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * 
     * @param ItemInterface[] $items
     * @return string
     */
    private function getPath($items)
    {
        $segments = [];
        foreach (Collection::create($items) as $item) {
            $segments[] = $item->getName();
        }
        return implode('/', $segments);
    }

}
