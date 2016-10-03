<?php

namespace Zalas\Symfify\Composer;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SymfifyCommand extends BaseCommand
{
    const VERSION = '1.0.0-dev';

    private $packages = [
        'symfony/framework-bundle',
    ];

    private $dirs = ['var/cache', 'var/logs', 'web', 'src'];

    protected function configure()
    {
        $this->setName('symfify');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf('<info>Symfify</info> version <comment>%s</comment>', self::VERSION));

        $this->installDependencies($output);
        $this->createDirectories($output);
        $this->createKernel($output);
        $this->createFrontController($output);
    }

    private function installDependencies(OutputInterface $output)
    {
        $output->writeln(sprintf('Installing <comment>%s</comment>', implode('</comment>, <comment>', $this->packages)));

        system(sprintf('composer require -q %s', implode(' ', $this->packages)));
    }

    private function createDirectories(OutputInterface $output)
    {
        foreach ($this->dirs as $dir) {
            if (is_dir($dir)) {
                $output->writeln(sprintf('The <comment>%s</comment> directory already exists', $dir));

                continue;
            }

            $output->writeln(sprintf('Creating the <comment>%s</comment> directory', $dir));
            if (!@mkdir($dir, 0777, true) && !@is_dir($dir)) {
                throw new \RuntimeException(sprintf('Failed to create the "%s" directory.', $dir));
            }
        }
    }

    private function createKernel(OutputInterface $output)
    {
        $kernelPath = './src/AppKernel.php';

        if (file_exists($kernelPath)) {
            $output->writeln(sprintf('The kernel already exists: <comment>%s</comment>', $kernelPath));

            return;
        }

        $output->writeln(sprintf('Creating the kernel: <comment>%s</comment>', $kernelPath));

        file_put_contents($kernelPath, $this->getKernelTemplate());
    }

    private function createFrontController(OutputInterface $output)
    {
        $frontControllerPath = './web/index.php';

        if (file_exists($frontControllerPath)) {
            $output->writeln(sprintf('The front controller already exists: <comment>%s</comment>', $frontControllerPath));

            return;
        }

        $output->writeln(sprintf('Creating the front controller: <comment>%s</comment>', $frontControllerPath));

        file_put_contents($frontControllerPath, $this->getFrontControllerTemplate());
    }

    private function getKernelTemplate()
    {
        return <<<'TMPL'
<?php

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class AppKernel extends Kernel
{
    use MicroKernelTrait;

    const SECRET = '$ecre7';

    /**
     * @return BundleInterface[]
     */
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
        ];
    }

    public function helloAction()
    {
        return new \Symfony\Component\HttpFoundation\Response('Hello!');
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->add('/', 'kernel:helloAction');
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        $c->loadFromExtension('framework', [
            'secret' => self::SECRET,
        ]);
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return __DIR__;
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        return dirname(__DIR__).'/../var/cache/'.$this->getEnvironment();
    }

    /**
     * @return string
     */
    public function getLogDir()
    {
        return dirname(__DIR__).'/../var/logs';
    }
}

TMPL;

    }

    private function getFrontControllerTemplate()
    {
        return <<<'TMPL'
<?php

use Symfony\Component\HttpFoundation\Request;

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../src/AppKernel.php';

$kernel = new AppKernel(getenv('SYMFONY_ENV') ?: 'dev', getenv('SYMFONY_DEBUG') !== '0');
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

TMPL;
    }
}
