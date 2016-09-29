<?php

namespace Zalas\Symfify\Composer;

use Composer\Command\BaseCommand;

class SymfifyCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('symfify');
    }
}