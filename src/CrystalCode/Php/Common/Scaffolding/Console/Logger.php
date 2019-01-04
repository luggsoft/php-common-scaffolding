<?php

namespace CrystalCode\Php\Common\Scaffolding\Util;

use Symfony\Component\Console\Output\OutputInterface;

final class Logger
{

    /**
     *
     * @var OutputInterface
     */
    private static $output;

    /**
     * 
     * @param OutputInterface $output
     * @return void
     */
    public static function setOutput(OutputInterface $output): void
    {
        self::$output = $output;
    }

    /**
     * 
     * @param iterable $messages
     * @return void
     */
    public static function log(string ...$messages): void
    {
        if (self::$output === null) {
            foreach ($messages as $message) {
                echo vsprintf('>>> %s' . PHP_EOL, [
                    trim($message),
                ]);
            }

            return;
        }

        self::$output->writeln($messages);
    }

}
