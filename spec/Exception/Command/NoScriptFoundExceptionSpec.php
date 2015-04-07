<?php

namespace spec\PhpZone\Shell\Exception\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NoScriptFoundExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('PhpZone\Shell\Exception\Command\NoScriptFoundException');
    }

    public function it_should_extend_base_exception()
    {
        $this->shouldHaveType('\Exception');
    }
}
