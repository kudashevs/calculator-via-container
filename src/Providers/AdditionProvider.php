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

        $this->registerAliases();
    }

    protected function registerAliases(): void
    {
        foreach (self::ALIASES as $alias) {
            $this->container->alias($alias, Addition::class);
        }
    }
}