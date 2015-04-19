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
        $inputParameters = array(
            '--no-tty' => !$this->tty
        );

        if ($input->getOption('no-tty')) {
            $inputParameters['--no-tty'] = $input->getOption('no-tty');
        }

        foreach ($this->batchScript as $script) {
            $uniqueId = uniqid($this->getName() . ':');

            $command = new ScriptCommand($uniqueId, $script);
            $this->getApplication()->add($command);

            $inputParameters['command'] = $uniqueId;

            $command = $this->getApplication()->find($uniqueId);
            $command->run(new ArrayInput($inputParameters), $output);
        }
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }
}
