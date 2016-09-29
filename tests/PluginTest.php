<?php

namespace Zalas\Symfify\Composer;

use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;

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
}
