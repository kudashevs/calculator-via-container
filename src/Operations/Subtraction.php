<?php

declare(strict_types=1);

namespace CalculatorViaContainer\Operations;

class Subtraction extends Operation
{
    /**
     * @inheritDoc
     */
    public function performCalculation(...$numbers)
    {
        $result = array_shift($numbers);

        foreach ($numbers as $number) {
            $result -= $number;
        }

        return $result;
    }
}
