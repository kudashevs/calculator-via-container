<?php

namespace CalculatorViaContainer\Operations;

class Multiplication extends Operation
{
    /**
     * @inheritDoc
     */
    public function performCalculation(...$numbers)
    {
        if (in_array(0, $numbers, true)) {
            return 0;
        }

        $result = array_shift($numbers);

        foreach ($numbers as $number) {
            $result *= $number;
        }

        return $result;
    }
}
