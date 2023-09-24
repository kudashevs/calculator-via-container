<?php

declare(strict_types=1);

namespace CalculatorViaContainer\Operations;

class Addition extends Operation
{
    /**
     * @inheritDoc
     */
    public function performCalculation(...$numbers)
    {
        $result = 0;

        foreach ($numbers as $number) {
            $result += $number;
        }

        return $result;
    }
}
