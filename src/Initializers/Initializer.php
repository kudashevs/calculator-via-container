<?php

declare(strict_types=1);

namespace CalculatorViaContainer\Initializers;

use CalculatorViaContainer\Container;

interface Initializer
{
    /**
     * Initialize container
     *
     * @param Container $container
     */
    public function init(Container $container): void;
}
