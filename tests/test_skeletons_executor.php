<?php

use CrystalCode\Php\Common\Skeletons\Executor;

require_once './bootstrap.php';

(function () {
    $targetPath = sprintf('%s/test_skeletons', __DIR__);
    $sourcePath = sprintf('%s/../src/CrystalCode', __DIR__);
    $sourceNamespaceName = 'CrystalCode\\Php\\Common\\Scaffolding';
    $executor = new Executor($targetPath, $sourcePath, $sourceNamespaceName);
    $executor->execute();
})();

