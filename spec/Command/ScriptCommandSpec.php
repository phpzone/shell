<?php

namespace spec\PhpZone\Shell\Command;

use PhpSpec\ObjectBehavior;
use PhpZone\Shell\Process\ProcessFactory;
use Prophecy\Argument;

class ScriptCommandSpec extends ObjectBehavior
{
    public function let(ProcessFactory $processFactory)
    {
        $this->beConstructedWith('command:test', array('ls'), $processFactory);
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

    public function it_should_fail_when_no_process_given(ProcessFactory $processFactory)
    {
        $this->shouldThrow('\RuntimeException')->during('__construct', array('test', array(), $processFactory));
    }
}
