<?php

namespace PhpZone\Shell\Process;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

class ProcessFactory
{
    /**
     * @param string $command
     *
     * @return Process
     */
    public function createByCommand($command)
    {
        $processBuilder = ProcessBuilder::create(explode(' ', $command));

        return $processBuilder->getProcess();
    }
}
