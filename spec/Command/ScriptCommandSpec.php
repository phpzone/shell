<?php

namespace spec\PhpZone\Shell\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Process\Process;

class ScriptCommandSpec extends ObjectBehavior
{
    public function let(Process $process)
    {
        $this->beConstructedWith('command:test', 'test description', array($process));
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('PhpZone\Shell\Command\ScriptCommand');
    }

    public function it_should_extend_symfony_command()
    {
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }

    public function it_should_have_name_when_name_given()
    {
        $this->getName()->shouldBeLike('command:test');
    }

    public function it_should_have_description_when_description_given()
    {
        $this->getDescription()->shouldBeLike('test description');
    }
}
