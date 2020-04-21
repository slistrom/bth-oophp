<?php
namespace Lii\Dice;

/**
 * Showing off a standard class with methods and properties.
 */
class Dice
{
    /**
    * @var integer number    The number of the rolled dice.
    */
    private $sides;
    private $number;

    /**
    * Constructor to create a Dice.
    *
    */
    public function __construct(int $sides = 6, int $number = null)
    {
        $this->sides = $sides;
        $this->number = $number;
        if ($number == null) {
            $this->roll();
        }
    }

    /**
    * Rolls the dice and assign a random number to it
    *
    */
    public function roll()
    {
        $this->number = rand(1, $this->sides);
    }

    /**
     * Get the number of the dice.
     *
     * @return int as the name of the person.
     */
    public function getNumber()
    {
        return $this->number;
    }
}
