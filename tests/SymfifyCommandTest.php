<?php

namespace Zalas\Symfify\Composer;

use Composer\Command\BaseCommand;

class SymfifyCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_is_a_composer_command()
    {
        $command = new SymfifyCommand();

        $this->assertInstanceOf(BaseCommand::class, $command);
        $this->assertSame('symfify', $command->getName());
    }
}
