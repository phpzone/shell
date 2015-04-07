<?php

namespace PhpZone\Shell;

use PhpZone\PhpZone\Extension\Extension;
use PhpZone\Shell\Exception\Command\NoScriptFoundException;
use PhpZone\Shell\Process\ProcessFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class Shell implements Extension
{
    /** @var ContainerBuilder */
    private $container;

    /** @var ProcessFactory */
    private $processFactory;

    public function load(ContainerBuilder $container)
    {
        $this->container = $container;
        $this->processFactory = new ProcessFactory();

        $config = $container->getParameter(get_class($this));

        $this->createAndRegisterDefinitions($config);
    }

    private function createAndRegisterDefinitions(array $config = array())
    {
        foreach ($config as $commandName => $commandOptions) {
            $definition = $this->generateCommandDefinition($commandName, $commandOptions);

            $this->container->setDefinition('phpzone.shell.' . $commandName, $definition);
        }
    }

    /**
     * @param string $commandName
     * @param array $commandOptions
     *
     * @return Definition
     *
     * @throws NoScriptFoundException
     */
    private function generateCommandDefinition($commandName, array $commandOptions)
    {
        if (empty($commandOptions['script'])) {
            throw new NoScriptFoundException(sprintf(
                'Defined command "%s" does not have any script',
                $commandName
            ));
        }

        if (empty($commandOptions['description'])) {
            $commandOptions['description'] = null;
        }

        $definition = new Definition('PhpZone\Shell\Command\ScriptCommand');
        $definition->setArguments(
            array($commandName, $commandOptions['script'], $commandOptions['description'], $this->processFactory)
        );
        $definition->addTag('command');

        return $definition;
    }
}
