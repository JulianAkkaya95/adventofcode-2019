<?php
use aco\Classes\IntcodeComputer\IntcodeComputer;

require_once("../Classes/IntcodeComputer.php");

$intcodeComputer = new IntcodeComputer();

//part1
$intCode = file_get_contents("Input.txt");
$intcodeComputer->setIntCode($intCode);
$intcodeComputer->setIntCode(12, 1);
$intcodeComputer->setIntCode(2, 2);

$intcodeComputer->runIntcode();
echo "Solution part 1: " . $intcodeComputer->getIntCode(0) . "\n";


//Part2
for ($noun=0; $noun <= 99; $noun++) {
    for ($verb=0; $verb <= 99; $verb++) {
        $intcodeComputer->setIntCode($intCode);
        $intcodeComputer->setIntCode($noun, 1);
        $intcodeComputer->setIntCode($verb, 2);
        $intcodeComputer->runIntcode();
        if (19690720 == $intcodeComputer->getIntCode(0)) {
            break 2;
        }
    }
}

echo "Solution part 2: " . (100 * $noun + $verb) . "\n";
