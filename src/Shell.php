<?php

namespace PhpZone\Shell;

use PhpZone\PhpZone\Extension\Extension;
use PhpZone\Shell\Process\ProcessFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class Shell implements Extension
{
    public function load(ContainerBuilder $container)
    {
        $config = $container->getParameter(get_class($this));

        $this->createAndRegisterDefinitions($container, $config);
    }

    private function createAndRegisterDefinitions(ContainerBuilder $container, array $config = array())
    {
        $processFactory = new ProcessFactory();

        foreach ($config as $commandName => $commandOptions) {
            if (is_array($commandOptions)) {
                $definition = new Definition('PhpZone\Shell\Command\ScriptCommand');
                $definition->setArguments(array($commandName, $commandOptions, $processFactory));
                $definition->addTag('command');

                $container->setDefinition('phpzone.shell.' . $commandName, $definition);
            }
        }
    }
}
