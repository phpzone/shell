<?php

namespace PhpZone\Shell\Command;

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
     * @param array $script
     * @param string $description
     * @param ProcessFactory $processFactory
     */
    public function __construct($name, array $script, $description, ProcessFactory $processFactory)
    {
        $this->generateProcesses($processFactory, $script);
        $this->setDescription($description);

        parent::__construct($name);
    }

    private function generateProcesses(ProcessFactory $processFactory, array $script)
    {
        foreach ($script as $command) {
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
