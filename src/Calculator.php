<?php

declare(strict_types=1);

namespace CalculatorViaContainer;

use CalculatorViaContainer\Initializers\CalculatorInitializer;

class Calculator
{
    protected Container $container;

    public function __construct()
    {
        $this->initContainer();
    }

    private function initContainer(): void
    {
        $initializer = new CalculatorInitializer();
        $this->container = Container::initInstance($initializer);
    }

    public function __call(string $name, array $arguments)
    {
        if ($this->container->has($name)) {
            return $this->retrieveOperation($name)
                ->calculate(...$arguments);
        }

        throw new \BadMethodCallException(
            sprintf('Method %s was not found. Check the method name.', $name)
        );
    }

    /**
     * @throws EntryNotFound|ContainerExceptionInterface
     */
    private function retrieveOperation(string $name): Operation
    {
        return $this->container->get($name);
    }
}
