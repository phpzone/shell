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

    public function it_should_implement_symfony_di_extension()
    {
        $this->shouldImplement('Symfony\Component\DependencyInjection\Extension\ExtensionInterface');
    }
}
