<?php

namespace Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Init extends Command
{
    private const commandName = 'morloax:init';
    private string $rootDir = __DIR__ . '/../../../';
    private string $initDir = __DIR__ . '/utility/shells/init/';

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
        $htacces = file_get_contents($this->initDir . 'htaccess.txt');
        file_put_contents($this->initDir . '.htaccess', $htacces);

        $migrations = file_get_contents($this->initDir . 'migrations.txt');
        file_put_contents($this->rootDir . 'migrations.php', $migrations);

        $migrationsDb = file_get_contents($this->initDir . 'migrations-db.txt');
        file_put_contents($this->rootDir . 'migrations-db.php', $migrationsDb);
    }

    public function initPublic(): void
    {
        $htaccess = file_get_contents($this->initDir . 'public/htaccess.txt');
        file_put_contents($this->rootDir . 'public/.htaccess', $htaccess);

        $frontController = file_get_contents($this->initDir . 'public/index.txt');
        file_put_contents($this->rootDir . 'public/index.php', $frontController);
    }

    public function initApp(): void
    {
        $htaccess = file_get_contents($this->initDir . 'app/htaccess.txt');
        file_put_contents($this->rootDir . 'app/.htaccess', $htaccess);

        $controller = file_get_contents($this->initDir . 'app/HomeController.txt');
        file_put_contents($this->rootDir . 'app/Controller/HomeController.php', $controller);

        $homeView = file_get_contents($this->initDir . 'app/View/index.txt');
        file_put_contents($this->rootDir . 'app/View/index.php', $homeView);

        $headSection = file_get_contents($this->initDir . 'app/View/sections/head.txt');
        file_put_contents($this->rootDir . 'app/View/sections/head.php', $homeView);

        if (!mkdir($concurrentDirectory = $this->rootDir . 'app/Model') && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
    }

    public function initMiddleware(): void
    {
        $middlewareDir = $this->initDir . '/middleware';

        $middleware = file_get_contents($middlewareDir . '/Middleware.txt');
        file_put_contents($this->rootDir . 'middleware/Middleware.php', $middleware);

        $csrf = file_get_contents($middlewareDir . '/Csrf.txt');
        file_put_contents($this->rootDir . 'middleware/Csrf.php', $csrf);

        $session = file_get_contents($middlewareDir . '/Session.txt');
        file_put_contents($this->rootDir . 'middleware/Session.php', $session);

        $routeExists = file_get_contents($middlewareDir . '/RouteExists.txt');
        file_put_contents($this->rootDir . 'middleware/RouteExists.php', $routeExists);
    }

    public function initRoutes(): void
    {
        $web = file_get_contents($this->initDir . 'routes/web.txt');
        file_put_contents($this->rootDir . 'routes/web.php', $web);
    }
}