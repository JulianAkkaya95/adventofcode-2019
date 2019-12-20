<?php

use aco\Classes\IntcodeComputer\IntcodeComputer;

require_once("../Classes/IntcodeComputer.php");

$intCode = file_get_contents("Input.txt");
$intcodeComputer = new IntcodeComputer();

//Part1
$intcodeComputer->setIntCode($intCode);
$intcodeComputer->setInput(1);
$intcodeComputer->runIntcode();
$output = $intcodeComputer->getOutput();

echo "Solution part 1: " . end($output) . "\n";
