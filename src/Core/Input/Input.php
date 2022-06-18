<?php

declare(strict_types=1);

namespace Sedmit\CommandLib\Core\Input;

class Input implements InputInterface
{
    private array $arguments = [];

    private array $options = [];

    private array $tokens;

    public function __construct(array $argv = null)
    {
        $argv = $argv ?? $_SERVER['argv'] ?? [];

        // убираем наименование скрипта
        array_shift($argv);
        $this->tokens = $argv;

        if (!empty($this->tokens)) {

            $this->parse();
        }
    }

    private function parse()
    {
        $parseTokens = $this->tokens;
        // убираем наименование команды
        array_shift($parseTokens);
        if (!$parseTokens) {

            return;
        }
        foreach ($parseTokens as $token) {
            if (strpos($token, '{') === 0 && mb_substr($token, -1) === '}') {
                $this->arguments[] = mb_substr($token, 1, -1);
            } else if (strpos($token, '[') === 0 && mb_substr($token, -1) === ']') {
                $token = explode('=', $token);
                $optionName = mb_substr($token[0], 1);
                $optionValue = mb_substr($token[1], 0, -1);
                $this->options[$optionName][] = $optionValue;
            } else {
                $this->arguments[] = $token;
            }
        }
    }

    public function getFirstArgument(): ?string
    {
        return $this->tokens[0] ?? null;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
