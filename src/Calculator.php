<?php

declare(strict_types=1);

namespace CalculatorViaContainer;

use BadMethodCallException;
use CalculatorViaContainer\Exceptions\EntryNotFound;
use CalculatorViaContainer\Initializers\CalculatorInitializer;
use CalculatorViaContainer\Operations\Operation;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @method int|float add(int|float ...$numbers)
 * @method int|float addition(int|float ...$numbers)
 * @method int|float sub(int|float ...$numbers)
 * @method int|float subtraction(int|float ...$numbers)
 * @method int|float mult(int|float ...$numbers)
 * @method int|float multiply(int|float ...$numbers)
 * @method int|float multiplication(int|float ...$numbers)
 * @method int|float div(int|float ...$numbers)
 * @method int|float divide(int|float ...$numbers)
 * @method int|float division(int|float ...$numbers)
 */
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

    /**
     * @param string $name
     * @param array $arguments
     * @return int|float
     *
     * @throws BadMethodCallException|NotFoundExceptionInterface|ContainerExceptionInterface
     */
    public function __call(string $name, array $arguments)
    {
        if ($this->container->has($name)) {
            return $this->retrieveOperation($name)
                ->calculate(...$arguments);
        }

        throw new BadMethodCallException(
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
