<?php

declare(strict_types=1);

namespace CalculatorViaContainer\Operations;

use CalculatorViaContainer\Exceptions\InvalidOperationArgument;
use CalculatorViaContainer\Validators\Validator;

abstract class Operation
{
    protected Validator $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param int|float ...$numbers
     * @return int|float
     */
    abstract protected function performCalculation(...$numbers);

    /**
     * @param int|float ...$numbers
     * @return float|int
     *
     * @throws InvalidOperationArgument|\InvalidArgumentException
     */
    final public function calculate(...$numbers)
    {
        $this->validator->validate(...$numbers);

        return $this->performCalculation(...$numbers);
    }
}
