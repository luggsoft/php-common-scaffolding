<?php

namespace CrystalCode\Php\Common\Scaffolding;

use CrystalCode\Php\Common\Collections\Collection;
use CrystalCode\Php\Common\Injectors\InjectorInterface;
use CrystalCode\Php\Common\Scaffolding\Instructions\CreateDirectoryInstruction;
use CrystalCode\Php\Common\Scaffolding\Instructions\CreateFileInstruction;
use CrystalCode\Php\Common\Scaffolding\Instructions\InstructionInterface;
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
     * @param InjectorInterface $injector
     * @param callable[] $handlers
     */
    public function __construct(InjectorInterface $injector, $handlers = [])
    {
        parent::__construct($injector, $handlers);
        $this->templateRenderer = $injector->create(TemplateRendererInterface::class);
    }

    /**
     * 
     * @param DefaultFileItem $fileItem
     * @return InstructionInterface[]
     */
    public function handleFileItem(DefaultFileItem $fileItem)
    {
        $ancestorItems = $fileItem->getAncestorItems(true);
        $template = $fileItem->getTemplate();
        yield new CreateFileInstruction([
            'path' => $this->getPath($ancestorItems),
            'data' => $this->templateRenderer->renderTemplate($template),
        ]);
    }

    /**
     * 
     * @param DefaultDirectoryItem $directoryItem
     * @return InstructionInterface[]
     */
    public function handleDirectoryItem(DefaultDirectoryItem $directoryItem)
    {
        $ancestorItems = $directoryItem->getAncestorItems(true);
        yield new CreateDirectoryInstruction([
            'path' => $this->getPath($ancestorItems),
        ]);
        foreach ($directoryItem->getChildItems() as $childItem) {
            foreach ($this->processItem($childItem) as $instruction) {
                yield $instruction;
            }
        }
    }

    /**
     * 
     * @param ItemInterface[] $items
     * @return string
     */
    public function getPath($items)
    {
        $segments = [];
        foreach (Collection::create($items) as $item) {
            $segments[] = $item->getName();
        }
        return implode('/', $segments);
    }

}
