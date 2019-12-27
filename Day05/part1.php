<?php
namespace adc\part1;

require  __DIR__.'/../vendor/autoload.php';
require_once("../Classes/IntcodeComputer.php");

use aco\Classes\IntcodeComputer\IntcodeComputer;




$intCode = file_get_contents("Input.txt");
$intcodeComputer = new IntcodeComputer();

//Part1
$intcodeComputer->setIntCode($intCode);
$intcodeComputer->setInput(1);
$intcodeComputer->runIntcode();
$output = $intcodeComputer->getOutput();

echo "Solution part 1: " . end($output) . "\n";
