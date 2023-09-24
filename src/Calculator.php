<?php

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
            $operation = $this->container->get($name);
            return $operation->calculate(...$arguments);
        }

        throw new \BadMethodCallException(
            sprintf('Method %s was not found. Check the method name.', $name)
        );
    }
}
