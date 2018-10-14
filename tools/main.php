<?php

use CrystalCode\Php\Common\Injectors\AliasDefinition;
use CrystalCode\Php\Common\Injectors\Injector;
use CrystalCode\Php\Common\Scaffolding\DefaultDirectoryItem;
use CrystalCode\Php\Common\Scaffolding\DefaultFileItem;
use CrystalCode\Php\Common\Scaffolding\DefaultItemProcessor;
use CrystalCode\Php\Common\Scaffolding\Instructions\CompositeInstruction;
use CrystalCode\Php\Common\Scaffolding\Instructions\ExportInstructionProcessor;
use CrystalCode\Php\Common\Templates\DefaultTemplateRenderer;
use CrystalCode\Php\Common\Templates\TemplateRendererInterface;

require_once sprintf('%s/../vendor/autoload.php', __DIR__);

function main()
{
    $item = new DefaultDirectoryItem('dir1', function () {
        yield new DefaultFileItem('file1.txt');
        yield new DefaultFileItem('file2.txt');
        yield new DefaultFileItem('file3.txt');
        yield new DefaultDirectoryItem('dir2', function () {
            yield new DefaultFileItem('file4.txt');
            yield new DefaultFileItem('file5.txt');
            yield new DefaultFileItem('file6.txt');
        });
    });

    $injector = new Injector([
        new AliasDefinition(TemplateRendererInterface::class, DefaultTemplateRenderer::class),
    ]);

    $itemProcessor = new DefaultItemProcessor($injector);

    $instructions = $itemProcessor->processItem($item);

    $instructionProcessor = new ExportInstructionProcessor($injector);

    $instruction = new CompositeInstruction($instructions);

    $instructionProcessor->processInstruction($instruction);
}

main();
