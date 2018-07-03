<?php

declare(strict_types=1);

namespace Zalas\Symfify\Composer\SymfifyStep;

use Zalas\Symfify\Composer\SymfifyStep;

class ChangeWorkingDirectoryStep implements SymfifyStep
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    public function __invoke()
    {
        if (!\is_dir($this->path) || !\chdir($this->path)) {
            throw new \InvalidArgumentException(\sprintf('The given directory path does not exist: "%s".', $this->path));
        }
    }
}
