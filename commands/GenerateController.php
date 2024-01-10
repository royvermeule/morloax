<?php

namespace Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateController extends Command
{
    private const commandName = 'generate:controller';

    public function configure()
    {
        $this->setName(self::commandName);
        $this->addArgument('controllerName', InputArgument::REQUIRED);
        $this->setDescription('Generates a new controller');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $controllerDir = __DIR__ . '/../../../../app/Controller/';
        $controllerName = ucfirst($input->getArgument('controllerName'));

        if (file_exists($controllerDir . $controllerName)) {
            $output->writeln("Controller with the name $controllerName already exists.");

            return Command::FAILURE;
        }

        $controllerShell = file_get_contents(__DIR__ . '/utility/shells/controller.txt');
        $controller = str_replace('--name--', $controllerName, $controllerShell);

        file_put_contents($controllerDir . $controllerName . '.php', $controller);

        return Command::SUCCESS;
    }
}