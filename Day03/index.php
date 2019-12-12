<?php
$wires = explode("\n", file_get_contents("Input.txt"));
$grid = [];

foreach ($wires as $wireNumber => $wire) {
    $currentPositionOnGrid = ["x" => 0, "y" => 0];
    $wire = explode(",", $wire);
    $wireSection = 1;
    foreach ($wire as $instruction) {
        preg_match('/(U|R|D|L)(\d+)/', $instruction, $matches);
        for ($i = 0; $i < $matches[2]; $i++) {
            switch ($matches[1]) {
                case "U":
                    $currentPositionOnGrid["y"]++;
                    break;
                case "D":
                    $currentPositionOnGrid["y"]--;
                    break;
                case "R":
                    $currentPositionOnGrid["x"]++;
                    break;
                case "L":
                    $currentPositionOnGrid["x"]--;
                    break;
            }
            if (!isset($grid[$currentPositionOnGrid['x']][$currentPositionOnGrid['y']][$wireNumber])) {
                $grid[$currentPositionOnGrid['x']][$currentPositionOnGrid['y']][$wireNumber] = $wireSection;
            }
            if (count($wires) == count($grid[$currentPositionOnGrid['x']][$currentPositionOnGrid['y']])) {
                $distance = abs($currentPositionOnGrid['x']) + abs($currentPositionOnGrid['y']);
                if (!isset($shortestWay) || $shortestWay > $distance) {
                    $shortestWay = $distance;
                }
                $wireLength = $grid[$currentPositionOnGrid['x']][$currentPositionOnGrid['y']][0] + $grid[$currentPositionOnGrid['x']][$currentPositionOnGrid['y']][1];
                if (!isset($minWireLength) || $wireLength < $minWireLength) {
                    $minWireLength = $wireLength;
                }
            }
            $wireSection++;
        }
    }
}

echo "Solution part 1: " . $shortestWay . "\n";
echo "Solution part 2: " . $minWireLength . "\n";