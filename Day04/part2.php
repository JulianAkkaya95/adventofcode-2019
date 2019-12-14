<?php
list($min, $max) = explode("-", file_get_contents("Input.txt"));
$numberOfPasswords = 0;
for (;$min < $max; $min++) {
    $integerAsArray = str_split($min);
    if (in_array(2, array_count_values($integerAsArray))) {
        $hasDouble = true;
    } else {
        continue;
    }
    for ($i = 0; $i < count($integerAsArray) - 1; $i++) {
        if ($integerAsArray[$i] > $integerAsArray[$i+1]) {
            break;
        }
        if (!isset($integerAsArray[$i+2]) && $hasDouble) {
            $numberOfPasswords++;
        }
    }
}
echo "Solution part 2: " . $numberOfPasswords . "\n";