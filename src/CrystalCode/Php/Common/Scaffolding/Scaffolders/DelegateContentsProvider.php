<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders;

final class DelegateContentsProvider implements ContentsProviderInterface
{

    /**
     *
     * @var callable
     */
    private $getContentsDelegate;

    /**
     * 
     * @param callable $getContentsDelegate
     */
    public function __construct(callable $getContentsDelegate)
    {
        $this->getContentsDelegate = $getContentsDelegate;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getContents(): string
    {
        return (string) call_user_func($this->getContentsDelegate);
    }

}
