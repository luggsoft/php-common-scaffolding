<?php

namespace CrystalCode\Php\Common\Scaffolding\Templates;

use CrystalCode\Php\Common\Scaffolding\FileItemBase;
use CrystalCode\Php\Common\Templates\TemplateBase;

abstract class FileItemTemplateBase extends TemplateBase
{

    /**
     *
     * @var FileItemBase
     */
    private $fileItem;

    /**
     * 
     * @param FileItemBase $fileItem
     */
    public function __construct(FileItemBase $fileItem)
    {
        $this->fileItem = $fileItem;
    }

    /**
     * 
     * @return FileItemBase
     */
    final public function getFileItem()
    {
        return $this->fileItem;
    }

    /**
     * 
     * @param bool $includeExtension
     * @return array|string[]
     */
    final public function getQualifiedNameSegments($includeExtension = false)
    {
        $nameSegments = [];
        foreach ($this->fileItem->getAncestorItems(true) as $item) {
            $nameSegments[] = $item->getName();
        }
        if ($includeExtension) {
            $nameSegments[] = $this->fileItem->getExtension();
        }
        return $nameSegments;
    }

    /**
     * 
     * @param string $separator
     * @param bool $includeExtension
     * @return string
     */
    final public function getQualifiedName($separator = '/', $includeExtension = false)
    {
        $nameSegments = $this->getQualifiedNameSegments($includeExtension);
        if ($includeExtension) {
            $extension = array_pop($nameSegments);
            return vsprintf('%s.%s', [
                implode($separator, $nameSegments),
                $extension,
            ]);
        }
        return implode($separator, $nameSegments);
    }

}
