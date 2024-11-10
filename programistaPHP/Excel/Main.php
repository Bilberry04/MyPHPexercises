<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Przykład konwersji komórek</title>
</head>
<body>
    <h1>Przykład konwersji komórek Excel na numeryczną wartość</h1>

    <p>
        <?php
        function columnToNumber($column) {
            $length = strlen($column);
            $number = 0;

            for ($i = 0; $i<$length; $i++){
                  $letter = $column[$i];
                  $value = ord($letter) - ord('A') + 1;
                  $number = $number * 26 + $value;
            }
            return $number;
        }

        function cellToNumeric($cell) {
            preg_match('/([A-Z]+)(\d+)/', $cell, $matches);
            $column = $matches[1];
            $row = $matches[2];
            $columnNumber = columnToNumber($column);
            return $columnNumber . "." . $row;
        }

        echo "Komórka A1 to: " . cellToNumeric('A1') . "<br>";
        echo "Komórka A2 to: " . cellToNumeric('A2') . "<br>";
        echo "Komórka B30 to: " . cellToNumeric('B30') . "<br>";
        echo "Komórka D100 to: " . cellToNumeric('D100') . "<br>";
        echo "Komórka G320 to: " . cellToNumeric('G320') . "<br>";

        ?>
    </p>
</body>
</html>