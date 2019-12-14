<?php
list($min, $max) = explode("-", file_get_contents("Input.txt"));
$numberOfPasswords = 0;
while ($min < $max) {
    $hasDouble = false;
    $integerAsArray = str_split($min);
    foreach ($integerAsArray as $digitIndex => $digit) {
        if(isset($integerAsArray[$digitIndex - 1])) {
            if ($integerAsArray[$digitIndex - 1] == $integerAsArray[$digitIndex]) {
                $hasDouble = true;
            }
            if ($integerAsArray[$digitIndex - 1] > $integerAsArray[$digitIndex]) {
                break;
            }
        }
        if ($digitIndex == count($integerAsArray) - 1 && $hasDouble) {
            $numberOfPasswords++;
        }
    }
    $min++;
}
echo $numberOfPasswords;