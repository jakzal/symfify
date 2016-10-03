<?php

namespace Zalas\Symfify\Composer;

use Composer\Command\BaseCommand;
use Composer\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

/**
 * @group integration
 */
class SymfifyCommandTest extends \PHPUnit_Framework_TestCase
{
    private $workDir;

    private $projectDir;

    private $process;

    protected function setUp()
    {
        $this->projectDir = getcwd();
        $this->workDir = realpath(sys_get_temp_dir()).'/symfify';
        $fs = new Filesystem();
        $fs->remove($this->workDir);
        $fs->mkdir($this->workDir);
        chdir($this->workDir);
    }

    protected function tearDown()
    {
        chdir($this->projectDir);
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

    public function test_it_sets_up_a_working_symfony_app()
    {
        $commandTester = $this->createCommandTester();
        $commandTester->execute(['command' => 'symfify']);

        $this->startWebServer();

        $response = $this->httpGet('http://localhost:8000/');

        $this->assertContains('Installing symfony/framework-bundle', $commandTester->getDisplay());
        $this->assertFileExists($this->workDir.'/composer.json', 'Composer json is created.');
        $this->assertFileExists($this->workDir.'/vendor', 'Vendors are installed.');
        $this->assertFileExists($this->workDir.'/var/cache', 'The cache directory is created.');
        $this->assertFileExists($this->workDir.'/var/logs', 'The logs directory is created.');
        $this->assertFileExists($this->workDir.'/src/AppKernel.php', 'The kernel file is created.');
        $this->assertFileExists($this->workDir.'/web/index.php', 'The front controller is created.');
        $this->assertRegExp('/Hello!/smi', $response);
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

        sleep(1);
    }

    /**
     * @param string $url
     *
     * @return string
     */
    private function httpGet($url)
    {
        return (string) @file_get_contents($url);
    }
}
