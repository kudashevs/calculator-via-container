<?php

declare(strict_types=1);

namespace CalculatorViaContainer\Validators;

use CalculatorViaContainer\Exceptions\InvalidOperationArgument;

class DefaultValidator implements Validator
{
    /**
     * @inheritDoc
     */
    public function validate(...$arguments): void
    {
        $this->checkEmptyArguments($arguments);
        $this->checkNumericArguments($arguments);
    }

    private function checkEmptyArguments(array $arguments): void
    {
        if (count($arguments) === 0) {
            throw new InvalidOperationArgument('Please provide at least one argument.');
        }
    }

    private function checkNumericArguments(array $arguments)
    {
        foreach ($arguments as $argument) {
            if (!is_numeric($argument)) {
                throw new InvalidOperationArgument('Only numeric arguments are allowed.');
            }
        }
    }
}
