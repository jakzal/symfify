<?php

declare(strict_types=1);

namespace Zalas\Symfify\Composer;

use Composer\Plugin\Capability\CommandProvider as CapabilityCommandProvider;

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
