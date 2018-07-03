<?php

declare(strict_types=1);

namespace Zalas\Symfify\Composer;

use Composer\Plugin\Capability\CommandProvider as CapabilityCommandProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;

class CommandProviderTest extends TestCase
{
    public function test_it_is_a_composer_command_provider()
    {
        $this->assertInstanceOf(CapabilityCommandProvider::class, new CommandProvider());
    }

    public function test_it_creates_the_symfify_command()
    {
        $provider = new CommandProvider();

        $commands = $provider->getCommands();

        $this->assertInternalType('array', $commands);
        $this->assertContainsOnlyInstancesOf(Command::class, $commands);
        $this->assertContainsInstanceOf(SymfifyCommand::class, $commands);
    }

    /**
     * @param string $class
     * @param array  $commands
     */
    private function assertContainsInstanceOf($class, array $commands)
    {
        foreach ($commands as $command) {
            if ($command instanceof $class) {
                return;
            }
        }

        throw new \LogicException(\sprintf('Expected "%s" command to be found on the list of commands.', $class));
    }
}
