<?php

declare(strict_types=1);

namespace Sedmit\CommandLib\Core;

use RuntimeException;
use Sedmit\CommandLib\Core\Command\Command;
use Sedmit\CommandLib\Core\Command\CommandInterface;
use Sedmit\CommandLib\Core\Input\Input;
use Sedmit\CommandLib\Core\Input\InputInterface;

/**
 * Класс для поиска и запуска консольных команд
 */
class Application
{
    private array $commands = [];

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        if (!$this->validateConfig($config)) {
            throw new RuntimeException('Validation error in configuration file');
        }
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * @param InputInterface|null $input
     * @return void
     */
    public function run(InputInterface $input = null): void
    {
        if (!$input) {
            $input = new Input();
        }

        // Получение имени команды
        $commandName = $input->getFirstArgument();
        if (!$commandName) {
            $command = new Command('default', 'Команда по умолчанию');
            $command->setApplication($this);
        } else {
            // Поиск среди зарегистрированных команд
            $command = $this->findCommand($commandName);
        }

        $command->setInput($input);
        // Если есть аргумент {help}, то выводится описание команды
        if ($command->hasArgument('help')) {
            print_r(PHP_EOL.'Description: '.$command->getDescription().PHP_EOL.PHP_EOL);

            return;
        }
        $command->execute();
    }

    /**
     * @param string $commandName
     * @return CommandInterface
     */
    private function findCommand(string $commandName): CommandInterface
    {
        if (!isset($this->commands[$commandName])) {
            throw new RuntimeException('Command is not registered');
        }
        $className = $this->commands[$commandName]['className'];
        $description = $this->commands[$commandName]['description'] ?? null;

        return new $className($commandName, $description);
    }

    /**
     * @param array $config
     * @return bool
     */
    private function validateConfig(array $config): bool
    {
        if (isset($config['commands']) && is_array($config['commands'])) {
            $commandsConfig = $config['commands'];
            $this->commands = $commandsConfig;
            foreach ($commandsConfig as $command) {
                if (!isset($command['className'])) {

                    return false;
                }
            }
        }

        return true;
    }
}
