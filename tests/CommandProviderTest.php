<?php

namespace Zalas\Symfify\Composer;

use Composer\Plugin\Capability\CommandProvider as CapabilityCommandProvider;

class CommandProviderTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_is_a_composer_command_provider()
    {
        $this->assertInstanceOf(CapabilityCommandProvider::class, new CommandProvider());
    }
}
