<?php

namespace CPASimUSante\ItemSelectorBundle;

use Claroline\CoreBundle\Library\PluginBundle;
use Claroline\KernelBundle\Bundle\ConfigurationBuilder;
use CPASimUSante\ItemSelectorBundle\Installation\AdditionalInstaller;

/**
 * Bundle class.
 * Uncomment if necessary.
 */
class CPASimUSanteItemSelectorBundle extends PluginBundle
{
    public function getConfiguration($environment)
    {
        $config = new ConfigurationBuilder();
        return $config->addRoutingResource(__DIR__ . '/Resources/config/routing.yml', null, 'itemselector');
    }

    /*
    public function getAdditionalInstaller()
    {
        return new AdditionalInstaller();
    }
    */

    public function hasMigrations()
    {
        return true;
    }
}
