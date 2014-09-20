<?php

namespace BicingStats;

use AlexCarol\Component\Framework\Command;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class BicingStatsApplication
{

    /**
     * @var ContainerBuilder
     */
    private $serviceContainer;

    public function __construct()
    {
        // optimize this for
        $container = new ContainerBuilder();

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));

        $loader->load('services.yml');
        $loader->load('command_handlers.yml');
        $loader->load('queries.yml');

        $container->compile();

        $this->serviceContainer = $container;
    }

    public function handleCommand(Command $command)
    {
        $this
            ->serviceContainer
            ->get('command_handler.' . $command->getName())
            ->handle($command);
    }

    public function handleQuery(Query $query)
    {
        $this
            ->serviceContainer
            ->get('command_handler.' . $query->getName())
            ->handle($query);
    }

    public function getService($service)
    {
        return $this->serviceContainer->get($service);
    }
}

