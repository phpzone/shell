<?php

namespace spec\PhpZone\Shell\Exception\Console\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InvalidScriptExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('PhpZone\Shell\Exception\Console\Command\InvalidScriptException');
    }

    public function it_should_extend_base_exception()
    {
        $this->shouldHaveType('\Exception');
    }
}
