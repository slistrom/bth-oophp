<?php

namespace Lii\Dice;

use PHPUnit\Framework\TestCase;

/**
 * DiceHand test class.
 */
class HistogramTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $histogram = new Histogram();
        $this->assertInstanceOf("\Lii\Dice\Histogram", $histogram);
    }


    /**
     * Verify that the output of a histogram is a string.
     */
    public function testHistogramOutputAsString()
    {
        $histogram = new Histogram();
        $dice = new DiceHistogram();
        $dice->roll();
        $histogram->injectData($dice);
        $result = $histogram->getAsText();
        $this->assertIsString($result);
    }

    /**
     * Verify that a histogram can be populated, return an serie array and after
     * the histogram is reset the serie array is empty.
     */
    public function testHistogramSerieRetrieveAndReset()
    {
        $histogram = new Histogram();
        $dice = new DiceHistogram();
        $dice->roll();
        $histogram->injectData($dice);
        $result = $histogram->getSerie();
        $this->assertIsArray($result);
        $histogram->resetHistogram();
        $result = $histogram->getSerie();
        $this->assertEquals($result, []);
    }
}
