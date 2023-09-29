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
     * @var array<string, Provider>
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
        $providerNames = $this->retrieveProviders();

        foreach ($providerNames as $providerName) {
            $this->initProvider($providerName);
        }
    }

    /**
     * @return array<int, string>
     */
    private function retrieveProviders(): array
    {
        $files = $this->retrieveProviderFiles();

        return array_reduce($files, static function ($carry, $file) {
            [$name, $extension] = explode('.', $file);

            if ($name !== '' && $extension === 'php') {
                $carry[] = $name;
            }

            return $carry;
        }, []);
    }

    /**
     * @return array<string>
     */
    private function retrieveProviderFiles(): array
    {
        $files = scandir(self::PROVIDERS_DIRECTORY);

        return ($files !== false) ? $files : [];
    }

    private function initProvider(string $name): void
    {
        /** @var class-string<Provider> $className */
        $className = self::PROVIDERS_NAMESPACE . $name;

        if ($this->isBuildable($className)) {
            $this->providers[$name] = new $className($this->container);
        }
    }

    /**
     * @param class-string $class
     * @return bool
     */
    private function isBuildable(string $class): bool
    {
        try {
            return $this->isProvider($class)
                && !$this->isAbstractType($class);
        } catch (\ReflectionException $e) {
            return false;
        }
    }

    private function isProvider(string $class): bool
    {
        return is_a($class, Provider::class, true);
    }

    /**
     * @param class-string $class
     * @return bool
     *
     * @throws \ReflectionException
     */
    private function isAbstractType(string $class): bool
    {
        return (new ReflectionClass($class))->isAbstract();
    }

    private function registerProviders(): void
    {
        array_map(static function (Provider $provider): void {
            $provider->register();
        }, $this->providers);
    }
}
