<?php
$inputAsArray = explode("\n", file_get_contents("Input.txt"));
$fuel = 0;

foreach ($inputAsArray as $mass) {
	$fuel += floor($mass/3) - 2;	
}

echo "Solution part 1: " . $fuel . "\n";