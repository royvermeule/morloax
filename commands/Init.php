<?php

namespace Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Init extends Command
{
    private const commandName = 'init';

    public function configure()
    {
        $this->setName(self::commandName);
        $this->setDescription('Initialization of the morloax framework.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->initRoot();
        $this->initPublic();
        $this->initApp();
        $this->initMiddleware();
        $this->initRoutes();

        return Command::SUCCESS;
    }

    public function initRoot(): void
    {
        $this->createDirectory('migrations');

        $this->createFile('htaccess.txt', '.htaccess');
        $this->createFile('migrations.txt', 'migrations.php');
        $this->createFile('migrations-db.txt', 'migrations-db.php');
    }

    public function initPublic(): void
    {
        $this->createDirectory('public');

        $this->createFile('public/htaccess.txt', 'public/.htaccess');
        $this->createFile('public/index.txt', 'public/index.php');
    }

    public function initApp(): void
    {
        $this->createDirectory('app');
        $this->createDirectory('app/Controller');
        $this->createDirectory('app/View');
        $this->createDirectory('app/View/sections');
        $this->createDirectory('app/Model');

        $this->createFile('app/Controller/HomeController.txt', 'app/Controller/HomeController.php');
        $this->createFile('app/View/index.txt', 'app/View/index.php');
        $this->createFile('app/View/sections/head.txt', 'app/View/sections/head.php');
        $this->createFile('app/htaccess.txt', 'app/.htaccess');
        $this->createFile('app/settings.dist.txt', 'app/settings.dis.php');
    }

    public function initMiddleware(): void
    {
        $this->createDirectory('middleware');

        $middlewareDir = 'middleware';
        $this->createFile($middlewareDir . '/Middleware.txt', 'middleware/Middleware.php');
        $this->createFile($middlewareDir . '/Csrf.txt', 'middleware/Csrf.php');
        $this->createFile($middlewareDir . '/Session.txt', 'middleware/Session.php');
        $this->createFile($middlewareDir . '/RouteExists.txt', 'middleware/RouteExists.php');
    }

    public function initRoutes(): void
    {
        $this->createDirectory('routes');
        $this->createFile('routes/web.txt', 'routes/web.php');
    }

    private function createDirectory(string $directory): void
    {
        $path = __DIR__ . '/../../../../' . $directory;
        if (!file_exists($path)) {
            if (!mkdir($path, 0777, true) && !is_dir($path)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
            }
        }
    }

    private function createFile(string $source, string $destination): void
    {
        $content = file_get_contents(__DIR__ . '/utility/shells/init/' . $source);

        if (!$this->exists($destination)) {
            file_put_contents(__DIR__ . '/../../../../' . $destination, $content);
        }
    }

    private function exists(string $pathToFile): bool
    {
        if (file_exists(__DIR__ . '/../../../../' . $pathToFile)) {
            return true;
        }

        return false;
    }
}