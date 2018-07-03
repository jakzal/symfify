<?php

declare(strict_types=1);

namespace Zalas\Symfify\Composer\SymfifyStep;

use Symfony\Component\Console\Output\OutputInterface;
use Zalas\Symfify\Composer\SymfifyStep;

class InstallDependenciesStep implements SymfifyStep
{
    /**
     * @var array
     */
    private $dependencies = [
        'symfony/framework-bundle',
    ];

    /**
     * @var OutputInterface
     */
    private $output;

    public function __construct(OutputInterface $output, array $dependencies = [])
    {
        $this->output = $output;
        $this->dependencies = $dependencies ?: $this->dependencies;
    }

    public function __invoke()
    {
        $this->output->writeln(\sprintf('Installing <comment>%s</comment>', \implode('</comment>, <comment>', $this->dependencies)));

        \system(\sprintf('composer require -q %s', \implode(' ', \array_map('escapeshellarg', $this->dependencies))));
    }
}
