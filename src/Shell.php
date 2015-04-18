<?php

namespace PhpZone\Shell;

use PhpZone\PhpZone\Extension\AbstractExtension;
use PhpZone\Shell\Config\Definition\Configuration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Shell extends AbstractExtension
{
    /** @var ContainerBuilder */
    private $container;

    /** @var OptionsResolver */
    private $optionsResolver;

    public function load(array $config, ContainerBuilder $container)
    {
        $this->container = $container;

        $this->optionsResolver = new OptionsResolver();
        $this->configureOptions($this->optionsResolver);

        $processor = new Processor();
        $configuration = new Configuration();
        $processedConfig = $processor->processConfiguration($configuration, $config);

        $this->createAndRegisterDefinitions($processedConfig);
    }

    private function configureOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults(array(
            'description' => null,
            'help'        => null,
            'script'      => array(),
            'enable'      => true,
        ));
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
     * @throws MissingOptionsException
     * @throws InvalidOptionsException
     */
    private function generateCommandDefinition($commandName, array $commandOptions)
    {
        $resolvedCommandOptions = $this->optionsResolver->resolve($commandOptions);

        $definition = new Definition('PhpZone\Shell\Console\Command\BatchScriptCommand');
        $definition->setArguments(
            array($commandName, $resolvedCommandOptions)
        );
        $definition->addTag('command');

        return $definition;
    }
}
