<?php

use Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\Yaml\Yaml;
use BimData\IntentClient\DependencyInjection\IntentClientExtension;

class Application
{
    private $container;

    public function __construct()
    {
        $this->container = new ContainerBuilder();
    }

    public function build($configPath)
    {
        $userConfig = Yaml::parse($configPath);
        $this->container->loadFromExtension(new IntentClientExtension(), $userConfig);
        $this->container->compile();
    }
}
