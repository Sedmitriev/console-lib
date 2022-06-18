<?php

declare(strict_types=1);

namespace Sedmit\CommandLib\Command;

use Sedmit\CommandLib\Core\Command\Command;

class TestCommand extends Command
{
    /**
     * @return int
     */
    public function execute(): int
    {
        print_r(PHP_EOL.'Called command: '.$this->getName().PHP_EOL);
        $arguments = $this->getArguments();
        print_r(PHP_EOL.'Arguments:'.PHP_EOL);
        foreach ($arguments as $argument) {
            print_r('   -  '  .$argument.PHP_EOL);
        }
        $options = $this->getOptions();
        print_r(PHP_EOL.'Options:'.PHP_EOL);
        foreach ($options as $option => $values) {
            print_r('   -  '  .$option.PHP_EOL);
            foreach ($values as $value) {
                print_r("\t-  " .$value.PHP_EOL);
            }
        }

        return Command::SUCCESS;
    }

}
