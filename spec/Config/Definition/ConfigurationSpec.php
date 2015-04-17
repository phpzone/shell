<?php

namespace spec\PhpZone\Shell\Config\Definition;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigurationSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('PhpZone\Shell\Config\Definition\Configuration');
    }

    public function it_should_implement_symfony_configuration_interface()
    {
        $this->shouldImplement('Symfony\Component\Config\Definition\ConfigurationInterface');
    }
}
