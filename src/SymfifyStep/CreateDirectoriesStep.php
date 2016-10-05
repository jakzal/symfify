<?php

namespace Zalas\Symfify\Composer\SymfifyStep;

use Symfony\Component\Console\Output\OutputInterface;
use Zalas\Symfify\Composer\SymfifyStep;

class CreateDirectoriesStep implements SymfifyStep
{
    /**
     * @var OutputInterface
     */
    private $output;

    private $dirs = ['var/cache', 'var/logs', 'web', 'src'];

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function __invoke()
    {
        foreach ($this->dirs as $dir) {
            $this->createDirectory($dir);
        }
    }

    /**
     * @param string $path
     */
    private function createDirectory($path)
    {
        if (is_dir($path)) {
            $this->output->writeln(sprintf('The <comment>%s</comment> directory already exists', $path));

            return;
        }

        $this->output->writeln(sprintf('Creating the <comment>%s</comment> directory', $path));

        if (!@mkdir($path, 0777, true) && !@is_dir($path)) {
            throw new \RuntimeException(sprintf('Failed to create the "%s" directory.', $path));
        }
    }
}