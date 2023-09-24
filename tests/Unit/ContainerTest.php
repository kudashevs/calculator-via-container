<?php

namespace CalculatorViaContainer\Tests\Unit;

use CalculatorViaContainer\Container;
use CalculatorViaContainer\Exceptions\EntryAlreadyExists;
use CalculatorViaContainer\Exceptions\EntryNotFound;
use CalculatorViaContainer\Initializers\Initializer;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        $this->initContainer();
    }

    protected function tearDown(): void
    {
        $this->resetContainer();
    }

    /** @test */
    public function it_can_throw_an_exception_when_an_unknown_id()
    {
        $this->expectException(EntryNotFound::class);
        $this->expectExceptionMessage('not found');

        $this->container->get('unknown');
    }

    /** @test */
    public function it_can_throw_an_exception_when_an_uknown_id_while_aliasing()
    {
        $this->expectException(EntryNotFound::class);
        $this->expectExceptionMessage('not found');

        $this->container->alias('test', 'unknown');
    }

    /** @test */
    public function it_can_throw_an_exception_when_an_alias_already_exists()
    {
        $container = Container::getInstance();
        $container->set(\stdClass::class, function () {
            return new \stdClass();
        });
        $container->alias('std', \stdClass::class);

        $this->expectException(EntryAlreadyExists::class);
        $this->expectExceptionMessage('std');

        $container->alias('std', \stdClass::class);
    }

    /** @test */
    public function it_can_be_initialized()
    {
        $initializerMock = $this->createMock(Initializer::class);
        $initializerMock->expects($this->once())
            ->method('init');

        Container::initInstance($initializerMock);
    }

    /** @test */
    public function it_can_set_a_dependency()
    {
        $container = Container::getInstance();
        $container->set(\stdClass::class, function () {
            return new \stdClass();
        });

        // assert that no exceptions were thrown
        $this->addToAssertionCount(1);

        return $container;
    }

    /**
     * @test
     * @depends it_can_set_a_dependency
     */
    public function it_can_get_a_dependency(Container $container)
    {
        $dependency = $container->get(\stdClass::class);

        $this->assertInstanceOf(\stdClass::class, $dependency);
    }

    /** @test */
    public function it_can_set_an_alias_to_a_dependency()
    {
        $container = Container::getInstance();
        $container->set(\stdClass::class, function () {
            return new \stdClass();
        });
        $this->container->alias('std', \stdClass::class);

        // assert that no exceptions were thrown
        $this->addToAssertionCount(1);

        return $container;
    }

    /**
     * @test
     * @depends it_can_set_an_alias_to_a_dependency
     */
    public function it_can_get_a_dependency_by_an_alias(Container $container)
    {
        $dependency = $container->get('std');
        $this->assertInstanceOf(\stdClass::class, $dependency);
    }

    /**
     * @test
     */
    public function it_can_set_aliases_to_a_dependency()
    {
        $container = Container::getInstance();
        $container->set(\stdClass::class, function () {
            return new \stdClass();
        });
        $this->container->alias('std', \stdClass::class);
        $this->container->alias('std_dependency', \stdClass::class);
        $this->container->alias('stdClass', \stdClass::class);

        // assert that no exceptions were thrown
        $this->addToAssertionCount(1);

        return $container;
    }

    /**
     * @test
     * @depends it_can_set_aliases_to_a_dependency
     */
    public function it_can_get_the_dependency_by_aliases(Container $container)
    {
        $aliases = ['std', 'std_dependency', 'stdClass'];

        foreach ($aliases as $alias) {
            $dependency = $container->get($alias);
            $this->assertInstanceOf(\stdClass::class, $dependency);
        }
    }

    /**
     * @test
     */
    public function it_can_check_whether_a_depency_is_registered()
    {
        $this->container->set(\stdClass::class, function () {
            return new \stdClass();
        });

        $this->assertTrue($this->container->has(\stdClass::class));
    }

    /** @test */
    public function it_can_check_whether_a_dependency_is_not_registered()
    {
        $this->assertFalse($this->container->has(Container::class));
    }

    private function initContainer(): void
    {
        $this->container = Container::getInstance();
    }

    private function resetContainer(): void
    {
        $reflection = new \ReflectionClass($this->container);
        $instance = $reflection->getProperty('instance');
        $instance->setAccessible(true);
        $instance->setValue(null, null);
        $instance->setAccessible(false);
    }
}
