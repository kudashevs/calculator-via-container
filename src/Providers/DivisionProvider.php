<?php

declare(strict_types=1);

namespace CalculatorViaContainer\Providers;

use CalculatorViaContainer\Operations\Division;
use CalculatorViaContainer\Validators\DefaultValidator;

class DivisionProvider extends Provider
{
    protected const ALIASES = [
        'division',
        'divide',
        'div',
    ];

    public function register(): void
    {
        $this->container->set(Division::class, function () {
            return new Division($this->container->get(DefaultValidator::class));
        });

        $this->container->set(DefaultValidator::class, function () {
            return new DefaultValidator();
        });

        $this->registerAliases();
    }

    protected function registerAliases(): void
    {
        foreach (self::ALIASES as $alias) {
            $this->container->alias($alias, Division::class);
        }
    }
}
