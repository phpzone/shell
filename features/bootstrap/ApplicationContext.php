<?php

namespace PhpZone\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use PhpZone\PhpZone\Application;
use Symfony\Component\Console\Tester\ApplicationTester;

/**
 * Defines application features from the specific context.
 */
class ApplicationContext implements Context, SnippetAcceptingContext
{
    /** @var Application */
    private $application;

    /** @var ApplicationTester */
    private $tester;

    /**
     * @beforeScenario
     */
    public function setUpEnvironment()
    {
        $this->setApplicationTest();
    }

    private function setApplicationTest()
    {
        $application = new Application('0.1.0');
        $application->setAutoExit(false);
        $this->application = $application;

        $this->tester = new ApplicationTester($this->application);
    }

    /**
     * @When I run phpzone with :command
     */
    public function iRunPhpzoneWith($command)
    {
        $this->tester->run(array($command));
    }

    /**
     * @Then I should see:
     */
    public function iShouldSee(PyStringNode $content)
    {
        expect($this->tester->getDisplay())->shouldBeLike($content->getRaw());
    }

    /**
     * @Then I should see :text in :command command description
     */
    public function iShouldSeeInCommandDescription($text, $command)
    {
        expect($this->application->get($command)->getDescription())->shouldBeLike($text);
    }
}
