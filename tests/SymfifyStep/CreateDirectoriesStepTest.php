<?php

namespace Zalas\Symfify\Composer\SymfifyStep;

use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Console\Output\OutputInterface;
use Zalas\Symfify\Composer\SymfifyStep;

class CreateDirectoriesStepTest extends \PHPUnit_Framework_TestCase
{
    use WorkDir;

    public function test_it_is_a_symfify_step()
    {
        $this->assertInstanceOf(SymfifyStep::class, new CreateDirectoriesStep($this->output()->reveal()));
    }

    public function test_it_creates_basic_directories()
    {
        $step = new CreateDirectoriesStep($this->output()->reveal());
        $step->__invoke();

        $this->assertFileExists($this->workDir.'/web', 'The web directory is created.');
        $this->assertFileExists($this->workDir.'/src', 'The src directory is created.');
        $this->assertFileExists($this->workDir.'/var/cache', 'The cache directory is created.');
        $this->assertFileExists($this->workDir.'/var/logs', 'The logs directory is created.');
    }

    public function test_it_ignores_already_created_directories()
    {
        mkdir($this->workDir.'/web', 0777);

        $step = new CreateDirectoriesStep($this->output()->reveal());
        $step->__invoke();

        $this->assertFileExists($this->workDir.'/src', 'The src directory is created.');
        $this->assertFileExists($this->workDir.'/var/cache', 'The cache directory is created.');
        $this->assertFileExists($this->workDir.'/var/logs', 'The logs directory is created.');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function test_it_throws_a_runtime_exception_if_directory_cannot_be_created()
    {
        file_put_contents($this->workDir.'/web', 'FOO');

        $step = new CreateDirectoriesStep($this->output()->reveal());
        $step->__invoke();
    }

    /**
     * @return OutputInterface|ObjectProphecy
     */
    private function output()
    {
        return $this->prophesize(OutputInterface::class);
    }
}
