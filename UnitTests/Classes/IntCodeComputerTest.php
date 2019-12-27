<?php
require __DIR__ . '/../../vendor/autoload.php';

use aco\Classes\IntcodeComputer\IntcodeComputer;
use PHPUnit\Framework\TestCase;

class IntCodeComputerTest extends TestCase
{
    function inputDataProvider()
    {
        return [
            [1]
        ];
    }

    /**
     * @dataProvider inputDataProvider
     */
    function testGetAndSetInput($input)
    {
        $intCodeComputer = new IntcodeComputer();
        $intCodeComputer->setInput($input);
        $this->assertEquals($intCodeComputer->getInput(), $input);
    }

    function intCodeDataProvider()
    {
        return [
            ["1,4,0,0,2,1,0,0,99"],
            [[1, 4, 0, 0, 2, 1, 0, 0, 99]]
        ];
    }

    /**
     * @dataProvider intCodeDataProvider
     */
    function testSetAndGetValidIntCode($intCode)
    {
        $intCodeComputer = new IntcodeComputer();
        $intCodeComputer->setIntCode($intCode);
        $this->assertEquals([1, 4, 0, 0, 2, 1, 0, 0, 99], $intCodeComputer->getIntCode());
        $this->assertEquals(1, $intCodeComputer->getIntCode(0));
        $this->assertEquals(4, $intCodeComputer->getIntCode(1));
        $this->assertEquals(2, $intCodeComputer->getIntCode(4));
    }

    function outputDataProvider()
    {
        return [
            [[1, 6, 8, 99, 10, 56567]],
            [[1]]
        ];
    }

    /**
     * @dataProvider outputDataProvider
     */
    function testSetAndGetOutput($outputs)
    {
        $intCodeComputer = new IntcodeComputer();
        foreach ($outputs as $output) {
            $intCodeComputer->setOutput($output);
        }
        $this->assertEquals($outputs, $intCodeComputer->getOutput());
        foreach ($outputs as $key => $output) {
            $this->assertEquals($output, $intCodeComputer->getOutput($key));
        }
    }

    function intCodeDataProvider2()
    {
        return [
            ["1,4,0,0,2,1,0,0,99", [12, 4, 0, 0, 2, 1, 0, 0, 99]],
            [[1, 4, 0, 0, 2, 1, 0, 0, 99], [12, 4, 0, 0, 2, 1, 0, 0, 99]],
            [[1, 9, 10, 3, 2, 3, 11, 0, 99, 30, 40, 50], [3500, 9, 10, 70, 2, 3, 11, 0, 99, 30, 40, 50]],
            [[1, 0, 0, 0, 99], [2, 0, 0, 0, 99]],
            [[2, 3, 0, 3, 99], [2, 3, 0, 6, 99]],
            [[2, 4, 4, 5, 99, 0], [2, 4, 4, 5, 99, 9801]],
            [[3, 0, 4, 0, 99], [1, 0, 4, 0, 99], 1, [1]],
        ];
    }

    /**
     * @dataProvider intCodeDataProvider2
     */
    function testRunIntCode($intCode, $expected, $input = NULL, $expectedOutput = NULL)
    {
        $intCodeComputer = new IntcodeComputer();
        $intCodeComputer->setIntCode($intCode);
        if (isset($input)) {
            $intCodeComputer->setInput($input);
        }
        $intCodeComputer->runIntcode();
        if (isset($expectedOutput)) {
            $this->assertEquals($intCodeComputer->getOutput(), $expectedOutput);
        }
        $this->assertEquals($intCodeComputer->getIntCode(), $expected);
    }
}