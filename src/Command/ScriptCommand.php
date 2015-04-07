<?php

namespace PhpZone\Shell\Command;

use PhpZone\Shell\Exception\Command\NoCommandsFoundException;
use PhpZone\Shell\Process\ProcessFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class ScriptCommand extends Command
{
    /** @var Process[] */
    private $processes = array();

    /**
     * @param string $name
     * @param array $commands
     * @param ProcessFactory $processFactory
     *
     * @throws NoCommandsFoundException
     */
    public function __construct($name, array $commands, ProcessFactory $processFactory)
    {
        if (count($commands) === 0) {
            throw new NoCommandsFoundException(sprintf(
                'Defined command "%s" does not have any command',
                $name
            ));
        }

        $this->generateProcesses($processFactory, $commands);

        parent::__construct($name);
    }

    private function generateProcesses(ProcessFactory $processFactory, array $commands)
    {
        foreach ($commands as $command) {
            $process = $processFactory->createByCommand($command);

            $this->processes[] = $process;
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->processes as $process) {
            $process->run(function ($type, $buffer) use ($output) {
                if (Process::ERR === $type) {
                    $output->write('ERR > ' . $buffer);
                } else {
                    $output->write($buffer);
                }
            });
        }
    }
}
