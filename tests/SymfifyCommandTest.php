<?php

declare(strict_types=1);

namespace Zalas\Symfify\Composer;

use Composer\Command\BaseCommand;
use Composer\Console\Application;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

/**
 * @group integration
 */
class SymfifyCommandTest extends TestCase
{
    /**
     * @var string
     */
    private $workDir;

    /**
     * @var Process|null
     */
    private $process;

    protected function setUp()
    {
        $this->workDir = \realpath(\sys_get_temp_dir()).'/symfify';
        $fs = new Filesystem();
        $fs->remove($this->workDir);
        $fs->mkdir($this->workDir);
    }

    protected function tearDown()
    {
        (new Filesystem())->remove($this->workDir);

        if (null !== $this->process) {
            $this->process->stop();
        }
    }

    public function test_it_is_a_composer_command()
    {
        $command = new SymfifyCommand();

        $this->assertInstanceOf(BaseCommand::class, $command);
        $this->assertSame('symfify', $command->getName());
    }

    /**
     * @expectedException \Symfony\Component\Console\Exception\RuntimeException
     */
    public function test_the_path_is_required()
    {
        $this->executeCommand([]);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_throws_an_invalid_argument_exception_if_the_path_does_not_exist()
    {
        $this->executeCommand(['path' => '/tmp/foobarbazampf']);
    }

    /**
     * @group slow
     */
    public function test_it_sets_up_a_working_symfony_app()
    {
        $this->executeCommand(['path' => $this->workDir]);

        $this->startWebServer();

        $response = $this->httpGet('http://localhost:8000/');

        $this->assertRegExp('/Hello!/smi', $response);
    }

    /**
     * @param array $input
     *
     * @return CommandTester
     */
    private function executeCommand(array $input)
    {
        $commandTester = $this->createCommandTester();
        $commandTester->execute(\array_merge(['command' => 'symfify'], $input));

        return $commandTester;
    }

    /**
     * @return CommandTester
     */
    private function createCommandTester()
    {
        $app = new Application();
        $app->add(new SymfifyCommand());

        return new CommandTester($app->find('symfify'));
    }

    private function startWebServer()
    {
        $this->process = new Process('php -S localhost:8000 -t web', $this->workDir);
        $this->process->start();

        \sleep(1);
    }

    /**
     * @param string $url
     *
     * @return string
     */
    private function httpGet($url)
    {
        return (string) @\file_get_contents($url);
    }
}
