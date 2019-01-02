<?php

namespace CrystalCode\Php\Common\Scaffolding\Scaffolders;

function test(): void
{
    $scaffolder = DirectoryScaffolderBuilder::create()
      ->withPath('src')
      ->withScaffolders(function () {
          yield FileScaffolderBuilder::create()
            ->withPath('foo.txt')
            ->build();

          yield FileScaffolderBuilder::create()
            ->withPath('qux.txt')
            ->build();

          yield FileScaffolderBuilder::create()
            ->withPath('zip.txt')
            ->build();
      })
      ->build();

    $processor = new Processor();
    $instructions = $processor->processScaffolder($scaffolder);

    foreach ($instructions as $instruction) {
        var_dump($instruction);
    }
}

test();
