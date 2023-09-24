<?php

declare(strict_types=1);

namespace CalculatorViaContainer;

use CalculatorViaContainer\Providers\Provider;
use ReflectionClass;

final class Initializer
{
    private const PROVIDERS_NAMESPACE = __NAMESPACE__ . '\\Providers\\';

    private Container $container;

    /**
     * @var Provider[]
     */
    private array $providers = [];

    public function __construct()
    {
    }

    public function init(Container $container): void
    {
        $this->initContainer($container);

        $this->buildProviders();
        $this->registerProviders();
    }

    private function initContainer(Container $container)
    {
        $this->container = $container;
    }

    private function buildProviders(): void
    {
        $providers = $this->retrieveProviders();

        foreach ($providers as $provider) {
            $this->buildProvider($provider);
        }
    }

    private function buildProvider(string $provider): void
    {
        $className = self::PROVIDERS_NAMESPACE . $provider;

        if ($this->isBuildable($className)) {
            $this->providers[$provider] = new $className($this->container);
        }
    }

    /**
     * @return array<string>
     */
    private function retrieveProviders(): array
    {
        $files = scandir(__DIR__ . '/Providers');

        return array_reduce($files, function ($carry, $file) {
            [$name, $extension] = explode('.', $file);

            if ($name !== '' && $extension === 'php') {
                $carry[] = $name;
            }

            return $carry;
        }, []);
    }

    private function isBuildable(string $class)
    {
        return is_a($class, Provider::class, true)
            && !$this->isAbstactType($class);
    }

    private function isAbstactType(string $class): bool
    {
        return (new ReflectionClass($class))->isAbstract();
    }

    private function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $provider->register();
        }
    }
}
