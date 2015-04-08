<?php

namespace PhpZone\Shell\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class ScriptCommand extends Command
{
    /** @var Process[] */
    private $processes;

    /**
     * @param string $name
     * @param null|string $description
     * @param array $processes
     */
    public function __construct($name, $description, array $processes)
    {
        $this->setDescription($description);

        $this->processes = $processes;


        parent::__construct($name);
        $this->configureOptions();
    }

    private function configureOptions()
    {
        $this->addOption(
            '--no-tty',
            null,
            InputOption::VALUE_NONE,
            'Disable TTY mode'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->processes as $process) {
            $process->setTty(!$input->getOption('no-tty'));
            $process->start();
            $process->wait(function ($type, $buffer) use ($output) {
                $output->write($buffer);
            });
        }
    }
}
