<?php

declare(strict_types=1);

namespace CalculatorViaContainer\Providers;

use CalculatorViaContainer\Operations\Subtraction;
use CalculatorViaContainer\Validators\DefaultValidator;

class SubtractionProvider extends Provider
{
    protected const ALIASES = [
        'subtraction',
        'sub',
    ];

    public function register(): void
    {
        $this->container->set(Subtraction::class, function () {
            return new Subtraction($this->container->get(DefaultValidator::class));
        });

        $this->container->set(DefaultValidator::class, function () {
            return new DefaultValidator();
        });

        $this->registerAliases();
    }

    protected function registerAliases(): void
    {
        foreach (self::ALIASES as $alias) {
            $this->container->alias($alias, Subtraction::class);
        }
    }
}
