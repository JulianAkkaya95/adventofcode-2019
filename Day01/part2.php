<?php
	$inputAsArray = explode("\n", file_get_contents("Input.txt"));
	$fuel = 0;

	foreach ($inputAsArray as $mass) {
		calculateFuel($mass, $fuel);
	}

	function calculateFuel($mass, &$fuel)
	{
		$mass = floor($mass/3) - 2;
		if (0 < $mass) {
			$fuel += $mass;
			calculateFuel($mass, $fuel);	
		}
	}
echo "Solution part 2: " . $fuel . "\n";