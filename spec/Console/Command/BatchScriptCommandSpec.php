<?php

namespace spec\PhpZone\Shell\Console\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BatchScriptCommandSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('command:test', 'test description', array('script'));
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('PhpZone\Shell\Console\Command\BatchScriptCommand');
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
