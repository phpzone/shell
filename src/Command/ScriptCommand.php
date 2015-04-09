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
    }

    protected function configure()
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
        $verbosity = $output->getVerbosity();

        $debugFormatter = null;

        if (OutputInterface::VERBOSITY_DEBUG == $verbosity) {
            // Backward compatibility: The Debug Formatter helper was introduced in Symfony 2.6.
            if ($this->getHelperSet()->has('debug_formatter')) {
                $debugFormatter = $this->getHelper('debug_formatter');
            }
        }

        foreach ($this->processes as $process) {
            $processId = spl_object_hash($process);

            if (OutputInterface::VERBOSITY_VERY_VERBOSE <= $verbosity) {
                if ($debugFormatter) {
                    $output->writeln($debugFormatter->start(
                        $processId,
                        $process->getCommandLine()
                    ));
                } else {
                    $this->printCommandLine($process, $output);
                }

            }

            $process->setTty(!$input->getOption('no-tty'));
            $process->start();
            $process->wait(function ($type, $buffer) use ($output, $verbosity, $debugFormatter, $processId) {
                if (OutputInterface::VERBOSITY_DEBUG == $verbosity) {
                    if ($debugFormatter) {
                        $output->writeln($debugFormatter->progress(
                            $processId,
                            $buffer,
                            Process::ERR === $type
                        ));
                    } else {
                        $output->write($buffer);
                    }
                } else {
                    $output->write($buffer);
                }
            });

            if (OutputInterface::VERBOSITY_DEBUG == $verbosity) {
                if ($debugFormatter) {
                    $output->writeln($debugFormatter->stop(
                        $processId,
                        sprintf('Exited with %d (%s)', $process->getExitCode(), $process->getExitCodeText()),
                        $process->isSuccessful()
                    ));
                }
            }
        }
    }

    private function printCommandLine(Process $process, OutputInterface $output)
    {
        $section = '<fg=white;bg=red> Command </fg=white;bg=red>';
        $commandLine = '<fg=black;bg=white> ' . $process->getCommandLine() . ' </fg=black;bg=white>';

        $output->writeln($section . $commandLine);
    }
}
