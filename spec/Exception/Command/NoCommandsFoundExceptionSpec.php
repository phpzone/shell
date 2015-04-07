<?php

namespace spec\PhpZone\Shell\Exception\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NoCommandsFoundExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('PhpZone\Shell\Exception\Command\NoCommandsFoundException');
    }

    public function it_should_extend_base_exception()
    {
        $this->shouldHaveType('\Exception');
    }
}
