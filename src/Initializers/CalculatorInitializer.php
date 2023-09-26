<?php

declare(strict_types=1);

namespace CalculatorViaContainer\Initializers;

use CalculatorViaContainer\Container;
use CalculatorViaContainer\Providers\Provider;
use ReflectionClass;

final class CalculatorInitializer implements Initializer
{
    private const PROVIDERS_NAMESPACE = 'CalculatorViaContainer\\Providers\\';
    private const PROVIDERS_DIRECTORY = __DIR__ . '/../Providers';

    private Container $container;

    /**
     * @var Provider[]
     */
    private array $providers = [];

    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function init(Container $container): void
    {
        $this->initContainer($container);

        $this->initProviders();
        $this->registerProviders();
    }

    private function initContainer(Container $container): void
    {
        $this->container = $container;
    }

    private function initProviders(): void
    {
        $providers = $this->retrieveProviders();

        foreach ($providers as $provider) {
            $this->initProvider($provider);
        }
    }

    /**
     * @return array<string>
     */
    private function retrieveProviders(): array
    {
        $files = scandir(self::PROVIDERS_DIRECTORY);

        return array_reduce($files, function ($carry, $file) {
            [$name, $extension] = explode('.', $file);

            if ($name !== '' && $extension === 'php') {
                $carry[] = $name;
            }

            return $carry;
        }, []);
    }

    private function initProvider(string $provider): void
    {
        $className = self::PROVIDERS_NAMESPACE . $provider;

        if ($this->isBuildable($className)) {
            $this->providers[$provider] = new $className($this->container);
        }
    }

    private function isBuildable(string $class): bool
    {
        return $this->isProvider($class)
            && !$this->isAbstractType($class);
    }

    private function isProvider(string $class): bool
    {
        return is_a($class, Provider::class, true);
    }

    private function isAbstractType(string $class): bool
    {
        return (new ReflectionClass($class))->isAbstract();
    }

    private function registerProviders(): void
    {
        array_map(static function (Provider $provider) {
            $provider->register();
        }, $this->providers);
    }
}
