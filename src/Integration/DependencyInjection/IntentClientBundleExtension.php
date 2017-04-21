<?php

namespace BimData\IntentClient\Integration\DependencyInjection;

use BimData\IntentClient\DependencyInjection\IntentClientExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class IntentClientBundleExtension extends IntentClientExtension {

    public function load(array $configs, ContainerBuilder $container) {
        parent::load($configs, $container);
    }
}