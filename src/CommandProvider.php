<?php

namespace Zalas\Symfify\Composer;

use Composer\Plugin\Capability\CommandProvider as CapabilityCommandProvider;
use Composer\Plugin\Capability\Composer;

class CommandProvider implements CapabilityCommandProvider
{
    /**
     * {@inheritdoc}
     */
    public function getCommands()
    {
        return [
            new SymfifyCommand(),
        ];
    }
}