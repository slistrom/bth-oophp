<?php
namespace Lii\Dice;

/**
 * A dicehand, consisting of dices.
 */
class DiceHand
{
    /**
    * @var Dice $dices   Array consisting of dices.
    * @var int  $values  Array consisting of last roll of the dices.
    */
    private $dices;
    private $values;

    /**
     * Constructor to initiate the dicehand with a number of dices.
     *
     * @param int $dices Number of dices to create, defaults to five.
     */
    public function __construct(int $dices = 5)
    {
        $this->dices  = [];
        $this->values = [];

        for ($i = 0; $i < $dices; $i++) {
//             $this->dices[$i]  = new Dice();
            $this->dices[$i]  = new DiceGraphic();
            $this->values[$i] = null;
        }
    }

    /**
     * Roll all dices save their value.
     *
     * @return void.
     */
    public function roll()
    {
        $dices = count($this->dices);
        for ($i = 0; $i < $dices; $i++) {
            $this->dices[$i]->roll();
            $value = $this->dices[$i]->getNumber();
            $this->values[$i] = $value;
        }
    }

    /**
     * Get values of dices from last roll.
     *
     * @return array with values of the last roll.
     */
    public function values()
    {
        return $this->values;
    }

    /**
     * Get the sum of all dices.
     *
     * @return int as the sum of all dices.
     */
    public function sum()
    {
        $sum = 0;
        $values = count($this->values);
        for ($i = 0; $i < $values; $i++) {
            $sum += $this->values[$i];
        }
        return $sum;
    }

    /**
     * Get the average of all dices.
     *
     * @return float as the average of all dices.
     */
    public function average()
    {
        return round($this->sum() / count($this->values), 2);
    }

    /**
     * Get the average of all dices.
     * @param int number Checking if a number is contained in the hand
     *
     * @return bool if number is contained or not
     */
    public function contain(int $number)
    {
        $contained = false;
        $values = count($this->values);
        for ($i = 0; $i < $values; $i++) {
            if ($this->values[$i] == $number) {
                $contained = true;
            }
        }
        return $contained;
    }
}
