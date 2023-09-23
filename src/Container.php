<?php

declare(strict_types=1);

namespace CalculatorViaContainer;

use CalculatorViaContainer\Exceptions\EntryNotFound;
use Psr\Container\ContainerInterface;

final class Container implements ContainerInterface
{
    private static ?Container $instance = null;

    private array $registered = [];

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }

    public function set(string $id, callable $factory): void
    {
        $this->registered[$id] = $factory;
    }

    public function get(string $id)
    {
        if (!array_key_exists($id, $this->registered)) {
            throw new EntryNotFound(
                sprintf('The requested instance %s was not found.', $id)
            );
        }

        return $this->registered[$id]($this);
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->registered);
    }
}
