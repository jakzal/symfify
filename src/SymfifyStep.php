<?php

declare(strict_types=1);

namespace Zalas\Symfify\Composer;

interface SymfifyStep
{
    public function __invoke();
}
