<?php

declare(strict_types=1);

namespace Sedmit\CommandLib\Core\Input;

interface InputInterface
{
    /**
     * @return string|null
     */
    public function getFirstArgument(): ?string;
}
