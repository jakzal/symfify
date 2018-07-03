<?php

declare(strict_types=1);

namespace Zalas\Symfify\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider as CapabilityCommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;

class Plugin implements PluginInterface, Capable
{
    /**
     * {@inheritdoc}
     */
    public function activate(Composer $composer, IOInterface $io)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getCapabilities()
    {
        return [
            CapabilityCommandProvider::class => CommandProvider::class,
        ];
    }
}
