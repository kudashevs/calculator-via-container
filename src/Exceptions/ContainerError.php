<?php

declare(strict_types=1);

namespace CalculatorViaContainer\Exceptions;

use Psr\Container\ContainerExceptionInterface;

class ContainerError extends \RuntimeException implements ContainerExceptionInterface
{
}
