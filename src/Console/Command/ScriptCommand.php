<?php

namespace PhpZone\Shell\Console\Command;

use PhpZone\Shell\Exception\Console\Command\InvalidScriptException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

class ScriptCommand extends Command
{
    /** @var string|array */
    private $script;

    /**
     * @param string $name
     * @param string|array $script
     */
    public function __construct($name, $script)
    {
        if ($script === null) {
            throw new InvalidScriptException('Command need to contain any script', 1);
        }

        $this->script = $script;

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
        if (is_array($this->script)) {
            $processBuilder = new ProcessBuilder();
            $processBuilder->setArguments($this->script);
            $process = $processBuilder->getProcess();
        } else {
            $process = new Process($this->script);
        }

        $processId = spl_object_hash($process);

        $verbosity = $output->getVerbosity();

        $debugFormatter = null;

        if (OutputInterface::VERBOSITY_DEBUG == $verbosity) {
            // Backward compatibility: The Debug Formatter helper was introduced in Symfony 2.6.
            if ($this->getHelperSet()->has('debug_formatter')) {
                $debugFormatter = $this->getHelper('debug_formatter');
            }
        }

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

    private function printCommandLine(Process $process, OutputInterface $output)
    {
        $section = '<fg=white;bg=red> Command </fg=white;bg=red>';
        $commandLine = '<fg=black;bg=white> ' . $process->getCommandLine() . ' </fg=black;bg=white>';

        $output->writeln($section . $commandLine);
    }
}
