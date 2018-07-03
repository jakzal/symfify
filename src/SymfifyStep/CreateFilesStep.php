<?php

declare(strict_types=1);

namespace Zalas\Symfify\Composer\SymfifyStep;

use Symfony\Component\Console\Output\OutputInterface;
use Zalas\Symfify\Composer\SymfifyStep;

class CreateFilesStep implements SymfifyStep
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var array
     */
    private $files = ['src/AppKernel.php', 'web/index.php'];

    public function __construct(OutputInterface $output, array $files = [])
    {
        $this->files = $files ?: $this->files;
        $this->output = $output;
    }

    public function __invoke()
    {
        foreach ($this->files as $file) {
            $this->createFile($file);
        }
    }

    /**
     * @param string $file
     */
    private function createFile($file)
    {
        if (\file_exists($file)) {
            $this->output->writeln(\sprintf('The file already exists: <comment>%s</comment>', $file));

            return;
        }

        $templateFile = __DIR__ . '/../../templates/' . $file;

        if (!\file_exists($templateFile)) {
            throw new \InvalidArgumentException(\sprintf('The template file not found: "%s".', $templateFile));
        }

        $this->output->writeln(\sprintf('Creating <comment>%s</comment>', $file));

        \file_put_contents($file, \file_get_contents($templateFile));
    }
}
