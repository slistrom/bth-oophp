<?php

namespace Lii\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Dice test class.
 */
class DiceTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Lii\Dice\Dice", $dice);
    }

    /**
     * Construct dice and roll and check that number is between 0 and 100.
     */
    public function testRollDiceCheckNumberRange()
    {
        $dice = new Dice();
        $dice->roll();
        $res = $dice->getNumber();
        $this->assertGreaterThan(0, $res);
        $this->assertLessThan(100, $res);
    }

    /**
     * Construct dice, roll it that number is numeric.
     */
    public function testRollDiceCheckNumberNumeric()
    {
        $dice = new Dice();
        $dice->roll();
        $res = $dice->getNumber();
        $this->assertIsNumeric($res);
    }
}
