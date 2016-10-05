<?php

namespace Zalas\Symfify\Composer\SymfifyStep;

use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Console\Output\OutputInterface;
use Zalas\Symfify\Composer\SymfifyStep;

class CreateFilesStepTest extends \PHPUnit_Framework_TestCase
{
    use WorkDir;

    private $files = ['src/AppKernel.php', 'web/index.php'];

    public function test_it_is_a_symfify_step()
    {
        $this->assertInstanceOf(SymfifyStep::class, new CreateFilesStep($this->output()->reveal()));
    }

    public function test_it_does_not_overwrite_the_file_if_it_already_exists()
    {
        $this->createDirectories();

        file_put_contents($this->files[0], 'FOO');

        $step = new CreateFilesStep($this->output()->reveal(), $this->files);
        $step();

        $this->assertSame('FOO', file_get_contents($this->files[0]));
    }

    public function test_it_creates_files()
    {
        $this->createDirectories();

        $step = new CreateFilesStep($this->output()->reveal(), $this->files);
        $step();

        foreach ($this->files as $file) {
            $this->assertFileEquals(__DIR__.'/../../templates/'.$file, $file);
        }
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_throws_an_invalid_argument_exception_if_the_template_file_is_missing()
    {
        $this->createDirectories();

        $step = new CreateFilesStep($this->output()->reveal(), ['foo.php']);
        $step();
    }

    private function createDirectories()
    {
        foreach ($this->files as $file) {
            mkdir(dirname($this->workDir . '/' . $file), 0777, true);
        }
    }

    /**
     * @return OutputInterface|ObjectProphecy
     */
    private function output()
    {
        return $this->prophesize(OutputInterface::class);
    }
}
