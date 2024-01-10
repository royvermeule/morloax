<?php

namespace Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateModel extends Command
{
    private const commandName = 'generate:model';

    public function configure(): void
    {
        $this->setName(self::commandName);
        $this->addArgument('modelName', InputArgument::REQUIRED);
        $this->setDescription('Generates a model');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $modelDir = __DIR__ . '/../../../../app/Model/';
        $modelName = ucfirst($input->getArgument('modelName'));

        if (file_exists($modelDir . $modelName)) {
            $output->writeln('Model by the name of ' . $modelName . ' already exists.');

            return Command::FAILURE;
        }

        $modelShell = file_get_contents(__DIR__ . '/utility/shells/model.txt');
        $model = str_replace('--name--', $modelName, $modelShell);

        file_put_contents($modelDir . $modelName, $model);

        return Command::SUCCESS;
    }
}