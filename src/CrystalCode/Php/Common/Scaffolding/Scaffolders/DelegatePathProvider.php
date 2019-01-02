<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders;

final class DelegatePathProvider implements PathProviderInterface
{

    /**
     *
     * @var callable
     */
    private $getPathDelegate;

    /**
     * 
     * @param callable $getPathDelegate
     */
    public function __construct(callable $getPathDelegate)
    {
        $this->getPathDelegate = $getPathDelegate;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return (string) call_user_func($this->getPathDelegate);
    }

}
