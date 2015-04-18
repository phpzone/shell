<?php

namespace spec\PhpZone\Shell\Console\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ScriptCommandSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('command:test', 'script');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('PhpZone\Shell\Console\Command\ScriptCommand');
    }

    public function it_should_extend_symfony_command()
    {
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }

    public function it_should_have_name_when_name_given()
    {
        $this->getName()->shouldBeLike('command:test');
    }
}
