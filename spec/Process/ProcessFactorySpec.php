<?php

namespace spec\PhpZone\Shell\Process;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProcessFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('PhpZone\Shell\Process\ProcessFactory');
    }

    public function it_should_create_process_when_command_given()
    {
        $command = 'ls';

        $process = $this->createByCommand($command);

        $process->shouldHaveType('Symfony\Component\Process\Process');
        $process->getCommandLine()->shouldBeLike("'" . $command . "'");
    }
}
