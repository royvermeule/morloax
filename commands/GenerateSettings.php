<?php

namespace Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSettings extends Command
{
    private string $commandName = 'generate:settings';

    protected function configure(): void
    {
        $this->setName($this->commandName);
        $this->setDescription('Generates/updates the settings.php file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $distSettingsDir = __DIR__ . '/../../../app/settings.dist.php';
        $localSettingsDir = __DIR__ . '/../../../app/settings.php';

        if (!file_exists($distSettingsDir)) {
            $output->writeln('settings.dist.php cannot be found please make sure you are on the latest version.');

            return Command::FAILURE;
        }

        if (!file_exists($localSettingsDir)) {
            file_put_contents($localSettingsDir, file_get_contents($distSettingsDir));
            $output->writeln('settings.php is generated.');

            return Command::SUCCESS;
        }

        $distDefines = $this->extractDefines($distSettingsDir);
        $localDefines = $this->extractDefines($localSettingsDir);

        $missingDefines = array_diff_key($distDefines, $localDefines);

        if (empty($missingDefines)) {
            $output->writeln('All the required settings are present.');

            return Command::SUCCESS;
        }

        $output->writeln('Changes have been found, updating settings!');

        $localSettingsContent = file_get_contents($localSettingsDir);
        foreach ($missingDefines as $defineName => $defineValue) {
            $localSettingsContent .= "\n" . "define('$defineName', $defineValue);";
        }
        file_put_contents($localSettingsDir, $localSettingsContent);

        return Command::SUCCESS;
    }

    private function extractDefines($filePath): array
    {
        $definesArray = [];

        $fileContents = file_get_contents($filePath);

        preg_match_all('/define\(\s*\'([^\']+)\'\s*,\s*([^\)]+)\);/', $fileContents, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $defineName = $match[1];
            $defineValue = $match[2];

            $definesArray[$defineName] = $defineValue;
        }

        return $definesArray;
    }
}