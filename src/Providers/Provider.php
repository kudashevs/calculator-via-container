<?php

declare(strict_types=1);

namespace CalculatorViaContainer\Providers;

use CalculatorViaContainer\Container;

abstract class Provider
{
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Register itself in the container.
     */
    abstract public function register(): void;
}
