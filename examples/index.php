<?php

namespace CalculatorViaContainer;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $calculator = new Calculator();
    echo $calculator->add(22, 42, 0) . PHP_EOL; // results in 64
    echo $calculator->multiply(5, 6, 8) . PHP_EOL; // results in 240
    echo $calculator->div(22.2, 2) . PHP_EOL; // results in 11.1
} catch (\Exception $e) {
    echo explainException($e);
}

function explainException(\Throwable $exception): string
{
    return sprintf(
        '%s: Something went wrong with a message "%s" in file %s on line %s.' . PHP_EOL,
        get_class($exception),
        $exception->getMessage(),
        $exception->getFile(),
        $exception->getLine(),
    );
}
