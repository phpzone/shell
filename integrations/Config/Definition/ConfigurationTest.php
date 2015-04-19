<?php

namespace PhpZone\Shell\Integration\Config\Definition;

use PhpZone\Shell\Config\Definition\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_should_properly_parse_configuration()
    {
        $configTest = array(
            'command:1' => array(
                'help'          => 'help text',
                'script'        => array(
                    'script command 1',
                    'script command 2',
                ),
                'enable'        => true,
                'tty'           => false,
                'stop-on-error' => true,
            ),
            1 => array(
                'name'        => 'command:2',
                'description' => 'description_value',
                'script'      => array(
                    'script command 3',
                ),
                'enable'      => false,
            ),
        );

        $configs = array($configTest);

        $processor = new Processor();
        $configuration = new Configuration();
        $processedConfiguration = $processor->processConfiguration($configuration, $configs);

        expect($processedConfiguration)->shouldBeLike(array(
            'command:1' => array(
                'help'          => 'help text',
                'script'        => array(
                    'script command 1',
                    'script command 2',
                ),
                'enable'        => true,
                'tty'           => false,
                'stop_on_error' => true,
            ),
            'command:2' => array(
                'description' => 'description_value',
                'script'      => array(
                    'script command 3',
                ),
                'enable'      => false,
            ),
        ));
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function test_it_should_fail_when_command_does_not_contain_script()
    {
        $configTest = array(
            'command' => null,
        );

        $configs = array($configTest);

        $processor = new Processor();
        $configuration = new Configuration();
        $processor->processConfiguration($configuration, $configs);
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function test_it_should_fail_when_command_has_empty_script()
    {
        $configTest = array(
            'command' => array(
                'script' => array(),
            ),
        );

        $configs = array($configTest);

        $processor = new Processor();
        $configuration = new Configuration();
        $processor->processConfiguration($configuration, $configs);
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function test_it_should_fail_when_command_contains_string_within_script()
    {
        $configTest = array(
            'command' => array(
                'script' => 'string',
            ),
        );

        $configs = array($configTest);

        $processor = new Processor();
        $configuration = new Configuration();
        $processor->processConfiguration($configuration, $configs);
    }
}
