<?php

namespace BimData\IntentClient\Integration;

use Symfony\Component\HttpKernel\Bundle\Bundle,
    Symfony\Component\DependencyInjection\ContainerBuilder;

class IntentClientBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}