<?php
function runIntcode ($intCode) {
	$i = 0;
	while ($intCode[$i] != 99) {
		if($intCode[$i] == 1) {
			$a = $intCode[$intCode[++$i]];
			$b = $intCode[$intCode[++$i]];
			$intCode[$intCode[++$i]] = $a + $b;
		} else if ($intCode[$i] == 2) {
			$a = $intCode[$intCode[++$i]];
			$b = $intCode[$intCode[++$i]];
			$intCode[$intCode[++$i]] = $a * $b;
		}
		$i++;
	}
	return $intCode[0];
}

//part1
$intCode = explode(",", file_get_contents("Input.txt"));
$intCode[1] = 12;
$intCode[2] = 2;
echo "Solution part 1: " . runIntcode($intCode) . "\n";

//part2
for ($noun=0; $noun <= 99; $noun++) {
	for ($verb=0; $verb <= 99; $verb++) {
		$intCode = explode(",", file_get_contents("Input.txt"));
		$intCode[1] = $noun;
		$intCode[2] = $verb;
		if (19690720 == runIntcode($intCode)) {
			echo "Solution part 2: " . (100 * $noun + $verb) . "\n";
			break 2;
		}
	}
}