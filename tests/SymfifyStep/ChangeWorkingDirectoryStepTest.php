<?php

declare(strict_types=1);

namespace Zalas\Symfify\Composer\SymfifyStep;

use PHPUnit\Framework\TestCase;
use Zalas\Symfify\Composer\SymfifyStep;

class ChangeWorkingDirectoryStepTest extends TestCase
{
    public function test_it_is_a_symfify_step()
    {
        $this->assertInstanceOf(SymfifyStep::class, new ChangeWorkingDirectoryStep(\sys_get_temp_dir()));
    }

    public function test_it_changes_the_working_directory()
    {
        $step = new ChangeWorkingDirectoryStep(\sys_get_temp_dir());
        $step();

        $this->assertSame(\realpath(\sys_get_temp_dir()), \realpath(\getcwd()));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_throws_an_invalid_argument_exception_if_the_path_does_not_exist()
    {
        $step = new ChangeWorkingDirectoryStep('/tmp/foobarbazampf');
        $step();
    }
}
