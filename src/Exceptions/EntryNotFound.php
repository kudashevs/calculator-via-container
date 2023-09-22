<?php

declare(strict_types=1);

namespace CalculatorViaContainer\Exceptions;

use Psr\Container\NotFoundExceptionInterface;

class EntryNotFound extends \InvalidArgumentException implements NotFoundExceptionInterface
{
}
