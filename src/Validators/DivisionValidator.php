<?php

namespace CalculatorViaContainer\Validators;

use CalculatorViaContainer\Exceptions\InvalidOperationArgument;

class DivisionValidator implements Validator
{
    /**
     * @inheritDoc
     */
    public function validate(...$arguments): void
    {
        $this->checkEmptyArguments($arguments);
        $this->checkNumericArguments($arguments);
        $this->checkZeroArguments($arguments);
    }

    private function checkEmptyArguments(array $arguments): void
    {
        if (count($arguments) === 0) {
            throw new InvalidOperationArgument('Please provide at least one argument.');
        }
    }

    private function checkNumericArguments(array $arguments): void
    {
        foreach ($arguments as $argument) {
            if (!is_numeric($argument)) {
                throw new InvalidOperationArgument('Only numeric arguments are allowed.');
            }
        }
    }

    private function checkZeroArguments(array $arguments): void
    {
        if (in_array(0, $arguments, false)) {
            throw new InvalidOperationArgument('Cannot divide by zero.');
        }
    }
}
