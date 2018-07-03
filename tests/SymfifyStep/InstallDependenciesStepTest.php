<?php

declare(strict_types=1);

namespace Zalas\Symfify\Composer\SymfifyStep;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Console\Output\OutputInterface;
use Zalas\Symfify\Composer\SymfifyStep;

class InstallDependenciesStepTest extends TestCase
{
    use WorkDir;

    public function test_it_is_a_symfify_step()
    {
        $this->assertInstanceOf(SymfifyStep::class, new InstallDependenciesStep($this->output()->reveal()));
    }

    /**
     * @group slow
     */
    public function test_it_installs_dependencies()
    {
        $step = new InstallDependenciesStep($this->output()->reveal(), ['symfony/debug']);
        $step();

        $this->assertFileExists($this->workDir.'/composer.json', 'composer.json is created.');
        $this->assertFileExists($this->workDir.'/vendor', 'Vendors are installed.');
    }

    /**
     * @return OutputInterface|ObjectProphecy
     */
    private function output()
    {
        return $this->prophesize(OutputInterface::class);
    }
}
