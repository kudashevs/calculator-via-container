<?php

declare(strict_types=1);

namespace CalculatorViaContainer\Providers;

use CalculatorViaContainer\Operations\Addition;
use CalculatorViaContainer\Validators\DefaultValidator;

class AdditionProvider extends Provider
{
    protected const ALIASES = [
        'addition',
        'add',
    ];

    public function register(): void
    {
        $this->container->set(Addition::class, function () {
            return new Addition($this->container->get(DefaultValidator::class));
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
            $this->container->alias($alias, Addition::class);
        }
    }
}
