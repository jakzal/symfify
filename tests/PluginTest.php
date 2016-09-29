<?php

namespace Zalas\Symfify\Composer;

use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;
use Composer\Plugin\Capability\CommandProvider as CapabilityCommandProvider;

class PluginTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_is_a_composer_plugin()
    {
        $this->assertInstanceOf(PluginInterface::class, new Plugin());
    }

    public function test_it_is_a_capable_plugin()
    {
        $this->assertInstanceOf(Capable::class, new Plugin());
    }

    public function test_has_a_command_provider_capability()
    {
        $plugin = new Plugin();

        $this->assertArraySubset([CapabilityCommandProvider::class => CommandProvider::class], $plugin->getCapabilities());
    }
}
