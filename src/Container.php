<?php

declare(strict_types=1);

namespace CalculatorViaContainer;

use CalculatorViaContainer\Exceptions\EntryAlreadyExists;
use CalculatorViaContainer\Exceptions\EntryNotFound;
use CalculatorViaContainer\Initializers\Initializer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class Container implements ContainerInterface
{
    private static ?Container $instance = null;

    /**
     * @var array<string, callable>
     */
    private array $registered = [];

    /**
     * @var string[][]
     */
    private array $aliases = [];

    public static function initInstance(Initializer $initializer): self
    {
        // When we want to initialize a container,
        // we also want to reset its previous state
        $container = new self();
        $initializer->init($container);
        self::$instance = $container;

        return self::$instance;
    }

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

    private function __clone()
    {
    }

    /**
     * Add an identifier with creation information to the container.
     *
     * @param string $id
     * @param callable $factory
     */
    public function set(string $id, callable $factory): void
    {
        $this->registered[$id] = $factory;
    }

    /**
     * Add an alias to an identifier to the container.
     *
     * @param string $alias
     * @param string $id
     *
     * @throws EntryAlreadyExists
     */
    public function alias(string $alias, string $id): void
    {
        if (!$this->isRegistered($id)) {
            throw new EntryNotFound(
                sprintf('The identifier "%s" was not found.', $id)
            );
        }

        if ($this->isAlias($alias)) {
            throw new EntryAlreadyExists(
                sprintf('The alias "%s" already exists.', $alias)
            );
        }

        $this->aliases[$id][] = $alias;
    }

    /**
     * Get an identifier or an alias from the container.
     *
     * @param string $id
     * @return mixed
     *
     * @throws EntryNotFound|NotFoundExceptionInterface|ContainerExceptionInterface
     */
    public function get(string $id)
    {
        if ($this->isRegistered($id)) {
            return $this->registered[$id]($this);
        }

        if ($this->isAlias($id)) {
            $aliasId = $this->getRegisteredByAlias($id);
            return $this->registered[$aliasId]($this);
        }

        throw new EntryNotFound(
            sprintf('The requested identifier "%s" was not found.', $id)
        );
    }

    /**
     * Determine whether an identifier or alias is registered.
     *
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return $this->isRegistered($id) || $this->isAlias($id);
    }

    private function isRegistered(string $id): bool
    {
        return array_key_exists($id, $this->registered);
    }

    private function isAlias(string $alias): bool
    {
        foreach (array_keys($this->aliases) as $key) {
            if (in_array($alias, $this->aliases[$key], true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @throws EntryNotFound
     */
    private function getRegisteredByAlias(string $alias): string
    {
        foreach (array_keys($this->aliases) as $key) {
            if (in_array($alias, $this->aliases[$key], true)) {
                return $key;
            }
        }

        throw new EntryNotFound(
            sprintf('The requested alias "%s" was not found.', $alias)
        );
    }
}
