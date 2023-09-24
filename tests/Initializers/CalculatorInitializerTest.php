<?php

namespace CalculatorViaContainer\Tests\Initializers;

use CalculatorViaContainer\Container;
use CalculatorViaContainer\Initializers\CalculatorInitializer;
use CalculatorViaContainer\Operations\Addition;
use PHPUnit\Framework\TestCase;

class CalculatorInitializerTest extends TestCase
{
    /** @test */
    public function it_can_initialize_a_container()
    {
        $container = Container::getInstance();
        $initializer = new CalculatorInitializer();
        $initializer->init($container);

        $addition = $container->get('addition');
        $this->assertInstanceOf(Addition::class, $addition);
    }
}
