<?php

namespace PhpZone\Shell\Integration\Console\Command;

use PhpZone\Shell\Console\Command\ScriptCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ScriptCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_should_run_process()
    {
        $command = new ScriptCommand('test', 'echo "test script"');

        $application = new Application();
        $application->add($command);

        $command = $application->find('test');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => 'test',
            '--no-tty' => true,
        ));

        expect(trim($commandTester->getDisplay()))->toBe('test script');
    }

    /**
     * @expectedException \PhpZone\Shell\Exception\Console\Command\InvalidScriptException
     */
    public function test_it_should_fail_when_no_script_given()
    {
        $command = new ScriptCommand('test', null);

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
