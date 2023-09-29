<?php

declare(strict_types=1);

namespace CalculatorViaContainer\Providers;

use CalculatorViaContainer\Operations\Multiplication;
use CalculatorViaContainer\Validators\DefaultValidator;

class MultiplicationProvider extends Provider
{
    protected const ALIASES = [
        'multiplication',
        'multiply',
        'mult',
    ];

    public function register(): void
    {
        $this->container->set(Multiplication::class, function () {
            return new Multiplication($this->container->get(DefaultValidator::class));
        });

        $this->container->set(DefaultValidator::class, function () {
            return new DefaultValidator();
        });

        $this->registerAliases(self::ALIASES);
    }

    /**
     * @param array<string> $aliases
     */
    protected function registerAliases(array $aliases): void
    {
        foreach ($aliases as $alias) {
            $this->container->alias($alias, Multiplication::class);
        }
    }
}
