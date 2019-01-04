<?php

namespace CrystalCode\Php\Common\Scaffolding\Console;

use ReflectionClass;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 
 * @var string
 */
const CONSOLE_APPLICATION_LOGO = <<<'LOGO'
   ____                _        _  ____          _        
  / ___|_ __ _   _ ___| |_ __ _| |/ ___|___   __| | ___   
 | |   | '__| | | / __| __/ _` | | |   / _ \ / _` |/ _ \  
 | |___| |  | |_| \__ \ || (_| | | |__| (_) | (_| |  __/  
  \____|_|   \__, |___/\__\__,_|_|\____\___/ \__,_|\___|  
 / ___|  ___ |___// _|/ _| ___ | | __| (_)_ __   __ _     
 \___ \ / __/ _` | |_| |_ / _ \| |/ _` | | '_ \ / _` |    
  ___) | (_| (_| |  _|  _| (_) | | (_| | | | | | (_| |    
 |____/ \___\__,_|_| |_|  \___/|_|\__,_|_|_| |_|\__, |    
                                                 |___/     
LOGO;

final class ConsoleApplication extends Application
{

    /**
     * 
     * @var string
     */
    const LOGO = CONSOLE_APPLICATION_LOGO;

    /**
     * 
     * {@inheritdoc}
     */
    public function getHelp()
    {
        return implode(PHP_EOL, [
            self::LOGO,
            parent::getHelp(),
        ]);
    }

    /**
     * 
     * {@inheritdoc}
     */
    protected function getDefaultCommands(): iterable
    {
        foreach (parent::getDefaultCommands() as $command) {
            yield $command;
        }

        yield (new Command('scaffold'))
            ->setCode([$this, 'executeScaffold'])
            ->setDescription('Executes the provided scaffolder')
            ->addOption('executor', null, InputOption::VALUE_REQUIRED, 'The fully qualified PHP class name of the Executor');

        yield (new Command('validate'))
            ->setCode([$this, 'executeValidate'])
            ->setDescription('Validates the provided scaffolder');
    }

    /**
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function executeScaffold(InputInterface $input, OutputInterface $output): int
    {
        $executorClassName = $input->getOption('executor');
        $classReflection = new ReflectionClass($executorClassName);
        $executor = $classReflection->newInstance();
        $executor->execute();
        $output->writeln(print_r($executor, true));
        return 0;
    }

    /**
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function executeValidate(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(__METHOD__);
        return 1;
    }

    /**
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function executeC(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(__METHOD__);
        return 2;
    }

}
