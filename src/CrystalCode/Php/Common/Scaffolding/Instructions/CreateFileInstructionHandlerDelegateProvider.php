<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

final class CreateFileInstructionHandlerDelegateProvider extends InstructionHandlerDelegateProviderBase
{

    /**
     *
     * @var bool
     */
    private $trimContents;

    /**
     * 
     * @param bool $trimContents
     */
    public function __construct(bool $trimContents = true)
    {
        $this->trimContents = $trimContents;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function canHandle(InstructionInterface $instruction): bool
    {
        return $instruction instanceof CreateFileInstruction;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getHandlerDelegate(): callable
    {
        return function (CreateFileInstruction $instruction) {
            $path = $instruction->getPath();
            $contents = $instruction->getContents();

            if ($this->trimContents) {
                $contents = trim($contents);
            }

            $permissions = $instruction->getPermissions();
            file_put_contents($path, $contents);
            chmod($path, $permissions);
        };
    }

}
