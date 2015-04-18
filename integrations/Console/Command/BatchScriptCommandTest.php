<?php

namespace PhpZone\Shell\Integration\Console\Command;

use PhpZone\Shell\Console\Command\BatchScriptCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class BatchScriptCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_should_run_process()
    {
        $options = array(
            'description' => null,
            'help'        => null,
            'script'      => array('echo test batch script'),
        );
        $command = new BatchScriptCommand('test', $options);

        $application = new Application();
        $application->add($command);

        $command = $application->find('test');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => 'test',
            '--no-tty' => true,
        ));

        expect(trim($commandTester->getDisplay()))->toBe('test batch script');
    }

    /**
     * @expectedException \PhpZone\Shell\Exception\Console\Command\InvalidScriptException
     */
    public function test_it_should_fail_when_no_scripts_given()
    {
        $options = array(
            'description' => null,
            'help'        => null,
            'script'      => array(),
        );
        $command = new BatchScriptCommand('test', $options);

        $application = new Application();
        $application->add($command);

        $command = $application->find('test');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => 'test',
            '--no-tty' => true,
        ));
    }
}
