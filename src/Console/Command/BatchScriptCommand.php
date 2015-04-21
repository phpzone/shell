<?php

namespace PhpZone\Shell\Console\Command;

use PhpZone\Shell\Exception\Console\Command\InvalidScriptException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BatchScriptCommand extends Command
{
    /** @var array[] */
    private $batchScript;

    /** @var bool */
    private $enabled = true;

    /** @var bool */
    private $tty = true;

    /** @var bool */
    private $stopOnError = false;

    /**
     * @param string $name
     * @param array $options
     */
    public function __construct($name, array $options)
    {
        if (empty($options['script'])) {
            throw new InvalidScriptException('Command need to contain any script', 1);
        }

        $this->batchScript = $options['script'];

        if (!empty($options['description'])) {
            $this->setDescription($options['description']);
        }

        if (!empty($options['help'])) {
            $this->setHelp($options['help']);
        }

        if (isset($options['enable'])) {
            $this->enabled = $options['enable'];
        }

        if (isset($options['tty'])) {
            $this->tty = $options['tty'];
        }

        if (isset($options['stop_on_error'])) {
            $this->stopOnError = $options['stop_on_error'];
        }

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

        $this->addOption(
            '--stop-on-error',
            null,
            InputOption::VALUE_NONE,
            'Stop on the first script error and avoid to process of remaining scripts'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $exitCode = 0;

        $inputParameters = array(
            '--no-tty' => !$this->tty
        );

        if ($input->getOption('no-tty')) {
            $inputParameters['--no-tty'] = $input->getOption('no-tty');
        }

        if ($input->getOption('stop-on-error')) {
            $this->stopOnError = true;
        }

        $errorRemainingScripts = array('Remaining scripts:');

        foreach ($this->batchScript as $index => $script) {
            if ($exitCode > 0 && $this->stopOnError) {
                $errorRemainingScripts[] = (sprintf('%d) %s', $index + 1, $script));
            } else {
                $uniqueId = uniqid($this->getName() . ':');

                $command = new ScriptCommand($uniqueId, $script);
                $this->getApplication()->add($command);

                $inputParameters['command'] = $uniqueId;

                $command = $this->getApplication()->find($uniqueId);
                $scriptExitCode = $command->run(new ArrayInput($inputParameters), $output);

                if ($scriptExitCode > 0) {
                    if ($this->stopOnError) {
                        $exitCode = $scriptExitCode;
                    } else {
                        $exitCode = 1;
                    }
                }
            }
        }

        if ($exitCode > 0 && $this->stopOnError) {
            $formattedBlock = $this->getHelper('formatter')->formatBlock($errorRemainingScripts, 'comment', true);
            $output->writeln($formattedBlock);
        }

        return $exitCode;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }
}
