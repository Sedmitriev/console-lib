<?php

declare(strict_types=1);

namespace Sedmit\CommandLib\Core\Command;

interface CommandInterface
{
    /**
     * @return int
     */
    public function execute(): int;
}
