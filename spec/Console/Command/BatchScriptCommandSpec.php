<?php

namespace spec\PhpZone\Shell\Console\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BatchScriptCommandSpec extends ObjectBehavior
{
    public function let()
    {
        $options = array(
            'description' => 'test description',
            'help'        => 'test help',
            'script'      => array('script'),
            'enable'      => false,
        );

        $this->beConstructedWith('command:test', $options);
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

    public function it_should_have_help_when_help_given()
    {
        $this->getHelp()->shouldBeLike('test help');
    }

    public function it_should_been_disabled_when_enable_false_given()
    {
        $this->isEnabled()->shouldBeLike(false);
    }
}
