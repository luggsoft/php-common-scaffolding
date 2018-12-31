<?php

use CrystalCode\Php\Common\Scaffolding\Console\ConsoleApplication;

require_once sprintf('%s/../vendor/autoload.php', __DIR__);

/**
 * 
 * @return int
 */
function main(): int
{
    $application = new ConsoleApplication();
    return (int) $application->run();
}

exit(main());
