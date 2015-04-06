<?php

namespace spec\PhpZone\Shell;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ShellSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('PhpZone\Shell\Shell');
    }

    public function it_should_implement_phpzone_extension()
    {
        $this->shouldImplement('PhpZone\PhpZone\Extension\Extension');
    }
}
