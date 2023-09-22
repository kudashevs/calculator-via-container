<?php

namespace CalculatorViaContainer\Tests;

use CalculatorViaContainer\Container;
use CalculatorViaContainer\Exceptions\EntryNotFound;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    /** @test */
    public function it_can_throw_an_exception_when_an_unknown_id()
    {
        $this->expectException(EntryNotFound::class);
        $this->expectExceptionMessage('not found');

        $container = Container::getInstance();
        $container->get('unknown');
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
}
