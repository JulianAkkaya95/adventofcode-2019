<?php

namespace aco\Classes\IntcodeComputer;

/**
 * The intcode computer is able to process intcode and return results.
 * @author Julian Akkaya
 * Classes IntcodeComputer
 * @package AdventOfCode\IntcodeComputer
 */
class IntcodeComputer
{
    /**
     * Instruction set for executing the individual instructions.
     */
    const ADD = 1;
    const MULTIPLY = 2;
    const DONE = 99;

    private $numberOfParameters = [
        self::ADD => 2,
        self::MULTIPLY =>  2
    ];

    /**
     * @var array
     */
    private $intCode;

    /**
     * Points to the current position to be executed.
     * @var int
     */
    private $pointer = 0;

    /**
     * Returns the complete intcode or a specific position of the intcode.
     * @param int $position
     * @return mixed
     */
    public function getIntCode( int $position = NULL)
    {
        if ($position === NULL) {
            $result = $this->intCode;
        } else {
            $result = $this->intCode[$position];
        }
        return $result;
    }

    /**
     * Sets the intCode to be processed.
     * @param array | string $intCode z.B. 1,2,3,0,99 or [1,2,3,0,99] or 1
     * @param null $position
     */
    public function setIntCode($intCode, $position = NULL)
    {
        if(is_array($intCode)) {
            $this->intCode = $intCode;
        } elseif ($position !== NULL && is_int($intCode)) {
            $this->intCode[$position] = $intCode;
        } elseif(!is_array($intCode) && $position === NULL)  {
            $this->intCode = explode(",", (string) $intCode);
        }
    }

    /**
     * Processes the given intcode, fetches the required instructions and parameters, executes the instructions and saves the results at a specified point.
     * @return void
     */
    public function runIntcode()
    {
        $this->pointer = 0;
        while ($this->intCode[$this->pointer] != self::DONE) {
            $instruction = $this->getInstructions($this->intCode[$this->pointer]);
            $t = $instruction["opcode"];
            $parameters = $this->getParameter($this->numberOfParameters[$t]);
            switch ($instruction["opcode"]) {
                case self::ADD:
                    $this->saveResult($parameters[0] + $parameters[1], $this->intCode[++$this->pointer]);
                    break;
                case self::MULTIPLY:
                    $this->saveResult($parameters[0] * $parameters[1], $this->intCode[++$this->pointer]);
                    break;
            }
            $this->pointer++;
        }
    }

    /**
     * Gets the parameters required for an instruction.
     * @param $numbersOfParameters int z.B. 2
     * @return array z.B. [1, 5, 10]
     */
    private function getParameter($numbersOfParameters)
    {
        $parametersAsArray = [];
        for ($j = 0; $j < $numbersOfParameters; $j++) {
            array_push($parametersAsArray, $this->intCode[$this->intCode[++$this->pointer]]);
        }
        return $parametersAsArray;
    }

    /**
     * Saves the calculated results.
     * @param int $result z.B. 10
     * @param int $positionForSaving z.B. 0
     * @return void
     */
    private function saveResult(int $result, int $positionForSaving) :void
    {
        $this->intCode[$positionForSaving] = $result;
    }

    /**
     * Get a code with the next command, including opcode and parameter modes.
     * @param int $code z.B. 10002
     * @return array z.B. ["opcode" => 02]
     */
    private function getInstructions( int $code)
    {
        return [
            "opcode" => substr($code, -2),
        ];
    }
}