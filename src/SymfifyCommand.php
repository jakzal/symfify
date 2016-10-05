<?php

namespace Zalas\Symfify\Composer;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zalas\Symfify\Composer\SymfifyStep\ChangeWorkingDirectoryStep;
use Zalas\Symfify\Composer\SymfifyStep\CreateDirectoriesStep;
use Zalas\Symfify\Composer\SymfifyStep\CreateFilesStep;
use Zalas\Symfify\Composer\SymfifyStep\CreateFrontControllerStep;
use Zalas\Symfify\Composer\SymfifyStep\CreateKernelStep;
use Zalas\Symfify\Composer\SymfifyStep\InstallDependenciesStep;

class SymfifyCommand extends BaseCommand
{
    const VERSION = '1.0.0';

    protected function configure()
    {
        $this->setName('symfify');
        $this->addArgument('path', InputArgument::REQUIRED, 'Path to symfify');
        $this->setDescription('Sets up a basic Symfony project in a code base that did not start as a Symfony project.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf('<info>Symfify</info> version <comment>%s</comment>', self::VERSION));
        $output->writeln('');

        $steps = [
            new ChangeWorkingDirectoryStep($input->getArgument('path')),
            new InstallDependenciesStep($output),
            new CreateDirectoriesStep($output),
            new CreateFilesStep($output),
        ];

        array_walk($steps, function (SymfifyStep $step) {
            $step();
        });
    }
}
