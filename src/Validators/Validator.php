<?php

namespace CalculatorViaContainer\Validators;

use CalculatorViaContainer\Exceptions\InvalidOperationArgument;

interface Validator
{
    /**
     * @param ...$arguments
     *
     * @throws InvalidOperationArgument
     */
    public function validate(...$arguments): void;
}
