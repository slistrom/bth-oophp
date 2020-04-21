<?php

namespace Lii\Dice;

use PHPUnit\Framework\TestCase;

/**
 * DiceHand test class.
 */
class DiceHandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $diceHand = new DiceHand();
        $this->assertInstanceOf("\Lii\Dice\DiceHand", $diceHand);
    }

    /**
     * Construct object and verify that the value
     * variable contains 5 dice by default.
     */
    public function testDiceHandValuesAmount()
    {
        $diceHand = new DiceHand();
        $diceHand->roll();
        $res = $diceHand->values();
        $arrayLenght = count($res);
        $this->assertEquals($arrayLenght, 5);
    }

    /**
     * Construct object and verify that the sum
     * of dices is an number.
     */
    public function testDiceHandSumNumeric()
    {
        $diceHand = new DiceHand();
        $diceHand->roll();
        $res = $diceHand->sum();
        $this->assertIsNumeric($res);
    }

    /**
     * Construct object and verify that the average
     * of dices is an number.
     */
    public function testDiceHandAverageNumeric()
    {
        $diceHand = new DiceHand();
        $diceHand->roll();
        $res = $diceHand->average();
        $this->assertIsNumeric($res);
    }

    /**
     * Construct object and verify that the contain function
     * returns true for a number in the DiceHand.
     */
    public function testDiceHandContain()
    {
        $diceHand = new DiceHand();
        $diceHand->roll();
        $res = $diceHand->values();
        $contains = $diceHand->contain($res[0]);
        $this->assertTrue($contains);
    }
}
