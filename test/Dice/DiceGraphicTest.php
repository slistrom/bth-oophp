<?php

namespace Lii\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Dice test class.
 */
class DiceGraphicTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dice = new DiceGraphic();
        $this->assertInstanceOf("\Lii\Dice\DiceGraphic", $dice);
    }

    /**
     * Construct dice and roll and check that number is between 0 and 100.
     */
    public function testRollDiceCheckNumberRange()
    {
        $dice = new DiceGraphic();
        $dice->roll();
        $res = $dice->getNumber();
        $this->assertGreaterThan(0, $res);
        $this->assertLessThan(100, $res);
    }

    /**
     * Construct dice, roll it and check that number is numeric.
     */
    public function testRollDiceCheckNumberNumeric()
    {
        $dice = new DiceGraphic();
        $dice->roll();
        $res = $dice->getNumber();
        $this->assertIsNumeric($res);
    }

    /**
     * Construct dice, roll it and check graphic class.
     */
    public function testRollDiceCheckGraphicClass()
    {
        $dice = new DiceGraphic();
        $dice->roll();
        $res = $dice->graphic();
        $this->assertIsString($res);
        $this->assertStringStartsWith('dice-', $res);
    }
}
