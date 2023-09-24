<?php

namespace CalculatorViaContainer\Tests;

use CalculatorViaContainer\Container;
use CalculatorViaContainer\Initializer;
use CalculatorViaContainer\Operations\Addition;
use PHPUnit\Framework\TestCase;

class InitializerTest extends TestCase
{
    /** @test */
    public function it_can_initialize_a_container()
    {
        $container = Container::getInstance();
        $initializer = new Initializer();
        $initializer->init($container);

        $addition = $container->get('addition');
        $this->assertInstanceOf(Addition::class, $addition);
    }
}
