<?php

use CrystalCode\Php\Common\Json\Json;
use CrystalCode\Php\Common\Json\NameMapperBuilder;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions\CompositeInstruction;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions\CreateDirectoryInstruction;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions\CreateFileInstruction;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions\RemoveDirectoryInstruction;
use CrystalCode\Php\Common\Scaffolding\Scaffolders\Instructions\RemoveFileInstruction;

require_once './require_all.php';

(function () {
    $instruction = new CompositeInstruction(...[
        new CreateFileInstruction('hello', 'world', 0777),
        new CreateDirectoryInstruction('hello/world', 0777),
    ]);


    $nameMapper = NameMapperBuilder::buildFromCallable(function (NameMapperBuilder $nameMapperBuilder) {
          $names = [
              CompositeInstruction::class,
              CreateDirectoryInstruction::class,
              CreateFileInstruction::class,
              RemoveDirectoryInstruction::class,
              RemoveFileInstruction::class,
          ];
          $nameMapperBuilder->withExternalNames(array_combine($names, $names));
      });

    $output = (new Json($nameMapper))->encode($instruction);
    var_dump($output);
})();
