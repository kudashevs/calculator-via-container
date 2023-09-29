<?php

declare(strict_types=1);

namespace CalculatorViaContainer\Providers;

use CalculatorViaContainer\Operations\Division;
use CalculatorViaContainer\Validators\DivisionValidator;

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
            return new Division($this->container->get(DivisionValidator::class));
        });

        $this->container->set(DivisionValidator::class, function () {
            return new DivisionValidator();
        });

        $this->registerAliases(self::ALIASES);
    }

    /**
     * @param array<string> $aliases
     */
    protected function registerAliases(array $aliases): void
    {
        foreach ($aliases as $alias) {
            $this->container->alias($alias, Division::class);
        }
    }
}
