<?php

namespace PhpZone\Shell;

use PhpZone\PhpZone\Extension\Extension;
use PhpZone\Shell\Process\ProcessFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Shell implements Extension
{
    /** @var ContainerBuilder */
    private $container;

    /** @var ProcessFactory */
    private $processFactory;

    /** @var OptionsResolver */
    private $optionsResolver;

    public function load(ContainerBuilder $container)
    {
        $this->container = $container;
        $this->processFactory = new ProcessFactory();

        $this->optionsResolver = new OptionsResolver();
        $this->configureOptions($this->optionsResolver);

        $config = $container->getParameter(get_class($this));

        $this->createAndRegisterDefinitions($config);
    }

    private function configureOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setRequired(array(
            'script',
        ));

        $optionsResolver->setDefaults(array(
            'description' => null,
        ));

        $optionsResolver->setAllowedTypes(array(
            'script' => 'array',
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
        $commandOptions = $this->optionsResolver->resolve($commandOptions);

        $definition = new Definition('PhpZone\Shell\Command\ScriptCommand');
        $definition->setArguments(
            array($commandName, $commandOptions['script'], $commandOptions['description'], $this->processFactory)
        );
        $definition->addTag('command');

        return $definition;
    }
}
