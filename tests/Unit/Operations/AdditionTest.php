<?php

namespace CalculatorViaContainer\Tests\Unit\Operations;

use CalculatorViaContainer\Operations\Addition;
use CalculatorViaContainer\Validators\Validator;
use PHPUnit\Framework\TestCase;

class AdditionTest extends TestCase
{
    private const MAX_PRECISION = 0.000000001;

    private Addition $addition;

    protected function setUp(): void
    {
        $validatorStub = $this->createStub(Validator::class);
        $this->addition = new Addition($validatorStub);
    }

    /** @test */
    public function it_can_process_one_argument()
    {
        $this->assertSame(2, $this->addition->calculate(2));
    }

    /** @test */
    public function it_can_process_two_arguments()
    {
        $this->assertSame(42, $this->addition->calculate(40, 2));
    }

    /** @test */
    public function it_can_process_multiple_arguments()
    {
        $this->assertSame(64, $this->addition->calculate(58, 3, 2, 1));
    }

    /** @test */
    public function it_can_process_a_zero_number()
    {
        $this->assertSame(42, $this->addition->calculate(42, 0));
    }

    /** @test */
    public function it_can_process_a_negative_number()
    {
        $this->assertSame(42, $this->addition->calculate(45, -3));
    }

    /**
     * @test
     * @dataProvider provideDifferentValues
     */
    public function it_can_perform_addition(array $values, $expected)
    {
        $this->assertEqualsWithDelta($expected, $this->addition->calculate(...$values), self::MAX_PRECISION);;
    }

    public function provideDifferentValues(): array
    {
        return [
            'add integer to integer' => [
                [12, 20],
                32,
            ],
            'add float to float' => [
                [0.5, 2.45],
                2.95,
            ],
            'add integer to float' => [
                [12.5, 5],
                17.5,
            ],
            'add float to integer' => [
                [5, 12.5],
                17.5,
            ],
        ];
    }
}
