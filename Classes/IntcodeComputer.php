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
    const INPUT = 3;
    const OUTPUT = 4;
    const DONE = 99;

    private $numberOfParameters = [
        self::ADD => 3,
        self::MULTIPLY => 3,
        self::INPUT => 1,
        self::OUTPUT => 1,
    ];

    /**
     * @var int
     */
    private $input;

    /**
     * @var array z.B. [1,12,5,0,99]
     */
    private $intCode;

    /**
     * @var array
     */
    private $output = [];

    /**
     * Points to the current position to be executed.
     * @var int
     */
    private $pointer = 0;

    /**
     * @return int
     */
    public function getInput(): int
    {
        return $this->input;
    }

    /**
     * @param int $input
     */
    public function setInput(int $input): void
    {
        $this->input = $input;
    }

    /**
     * Returns the complete intcode or a specific position of the intcode.
     * @param int $position
     * @return mixed
     */
    public function getIntCode(int $position = NULL)
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
    public function setIntCode($intCode, $position = NULL): void
    {
        if (is_array($intCode)) {
            $this->intCode = $intCode;
        } elseif ($position !== NULL && is_int($intCode)) {
            $this->intCode[$position] = $intCode;
        } elseif (!is_array($intCode) && $position === NULL) {
            $this->intCode = explode(",", (string)$intCode);
        }
    }

    /**
     * @param int $output
     */
    public function setOutput(int $output): void
    {
        array_push($this->output, $output);
    }

    /**
     * @return array | int
     */
    public function getOutput($position = NULL)
    {
        if(isset($position)) {
            $result = $this->output[$position];
        } else {
            $result = $this->output;
        }
        return $result;
    }

    /**
     * Processes the given intcode, fetches the required instructions and parameters,
     * executes the instructions and saves the results at a specified point.
     * @return void
     */
    public function runIntcode(): void
    {
        $this->pointer = 0;
        while ($this->intCode[$this->pointer] != self::DONE) {
            $instruction = $this->getInstructions($this->intCode[$this->pointer]);
            $parameters = $this->getParameter(
                $this->numberOfParameters[$instruction["opcode"]],
                $instruction["parameterModes"]
            );
            switch ($instruction["opcode"]) {
                case self::ADD:
                    $this->saveResult($parameters[0] + $parameters[1], $parameters[2]);
                    break;
                case self::MULTIPLY:
                    $this->saveResult($parameters[0] * $parameters[1], $parameters[2]);
                    break;
                case self::INPUT:
                    $this->saveResult($this->input, $parameters[0]);
                    break;
                case self::OUTPUT:
                    //We don't want to output the memory address but the variable behind it.
                    $this->setOutput($this->intCode[$parameters[0]]);
                    break;
            }
            $this->pointer++;
        }
    }

    /**
     * Gets the parameters required for an instruction. e.g. Parameter1, Parameter2, memory address
     * @param $numbersOfParameters int z.B. 2
     * @param $parameterModes array z.B. [0,1,1,0]
     * @return array z.B. [1, 5, 10]
     */
    private function getParameter($numbersOfParameters, $parameterModes)
    {
        //The parameter modes are stored from right to left, which is why they are run from back to front.
        $k = count($parameterModes) - 1;
        $parametersAsArray = [];
        for ($j = 0; $j < $numbersOfParameters - 1; $j++) {
            if (!isset($parameterModes[$k]) || $parameterModes[$k] == 0 || empty($parameterModes[$k] || $j == $numbersOfParameters - 1)) {
                array_push($parametersAsArray, $this->intCode[$this->intCode[++$this->pointer]]);
            } else {
                array_push($parametersAsArray, (int)$this->intCode[++$this->pointer]);
            }
            $k--;
        }
        //The position at which you want to save only needs the memory address and not the variable behind it.
        array_push($parametersAsArray, (int)$this->intCode[++$this->pointer]);
        return $parametersAsArray;
    }

    /**
     * Saves the calculated results.
     * @param int $result z.B. 10
     * @param int $positionForSaving z.B. 0
     * @return void
     */
    private function saveResult(int $result, int $positionForSaving): void
    {
        $this->intCode[$positionForSaving] = $result;
    }

    /**
     * Get a code with the next command, including opcode and parameter modes.
     * @param int $code z.B. 10002
     * @return array z.B. ["opcode" => 02]
     */
    private function getInstructions(int $code)
    {
        return [
            "opcode" => (int)substr($code, -2),
            "parameterModes" => str_split(substr($code, 0, -2))
        ];
    }
}