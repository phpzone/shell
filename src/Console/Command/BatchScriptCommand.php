<?php

namespace PhpZone\Shell\Console\Command;

use PhpZone\Shell\Exception\Console\Command\InvalidScriptException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BatchScriptCommand extends Command
{
    /** @var array[] */
    private $batchScript;

    /**
     * @param string $name
     * @param null|string $description
     * @param array $batchScript
     */
    public function __construct($name, $description, array $batchScript)
    {
        if (empty($batchScript)) {
            throw new InvalidScriptException('Command need to contain any script', 1);
        }

        $this->batchScript = $batchScript;

        $this->setDescription($description);

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
        $scriptInput = clone $input;

        foreach ($this->batchScript as $script) {
            $uniqueId = uniqid($this->getName() . ':');

            $command = new ScriptCommand($uniqueId, $script);
            $this->getApplication()->add($command);

            $scriptInput->setArgument('command', $uniqueId);

            $command = $this->getApplication()->find($uniqueId);
            $command->run($scriptInput, $output);
        }
    }
}
