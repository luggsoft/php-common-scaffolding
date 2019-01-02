<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders;

final class DelegateScaffoldersProvider implements ScaffoldersProviderInterface
{

    /**
     *
     * @var callable
     */
    private $getScaffoldersDelegate;

    /**
     * 
     * @param callable $getScaffoldersDelegate
     */
    public function __construct(callable $getScaffoldersDelegate)
    {
        $this->getScaffoldersDelegate = $getScaffoldersDelegate;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getScaffolders(): iterable
    {
        foreach (call_user_func($this->getScaffoldersDelegate) as $scaffolder) {
            yield $scaffolder;
        }
    }

}
