<?php

declare(strict_types=1);

namespace Sedmit\CommandLib\Core\Command;

use Sedmit\CommandLib\Core\Application;
use Sedmit\CommandLib\Core\Input\Input;

/**
 * Базовый класс для консольный команд
 */
class Command implements CommandInterface
{
    public const SUCCESS = 0;
    public const FAILURE = 1;

    private string $name;
    private ?string $description;
    private Application $application;
    private Input $input;

    /**
     * @param string $name
     * @param string|null $description
     */
    public function __construct(string $name, ?string $description = null)
    {
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Command
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Application
     */
    public function getApplication(): Application
    {
        return $this->application;
    }

    /**
     * @param Application $application
     * @return Command
     */
    public function setApplication(Application $application): self
    {
        $this->application = $application;

        return $this;
    }

    /**
     * @return Input
     */
    public function getInput(): Input
    {
        return $this->input;
    }

    /**
     * @param Input $input
     * @return Command
     */
    public function setInput(Input $input): Command
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Метод для получения аргументов
     *
     * @return array
     */
    public function getArguments(): array
    {
        return $this->input->getArguments();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasArgument(string $name): bool
    {
        $args = $this->input->getArguments();

        return in_array($name, $args);
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function getOption(string $name): ?array
    {
        $options = $this->input->getOptions();

        return array_key_exists($name, $options) ? $options[$name] : null;
    }

    /**
     * Метод для получения параметров
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->input->getOptions();
    }

    /**
     * @return int
     */
    public function execute(): int
    {
        $commands = $this->getApplication()->getCommands();
        if (empty($commands)) {
            print_r('Commands not registered');

            return self::SUCCESS;
        }

        $mask = "|%5s | %-30s \n";
        printf($mask, 'NAME', 'DESCRIPTION');
        foreach ($commands as $commandName => $value) {
            $description = $value['description'] ?? '';
            printf($mask, $commandName, $description);
        }

        return self::SUCCESS;
    }
}
