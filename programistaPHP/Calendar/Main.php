<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalendarz</title>
</head>
<body>
    <form method="POST">
        Miesiąc: <input type="number" name="month" min="1" max="12" required> 
        Rok: <input type="number" name="year" min="1900" max="2150" required>
        <input type="submit" value="Zatwierdź">
    </form>

    <?php 
    header('Content-Type: text/html; charset=UTF-8');
    
   
    setlocale(LC_ALL, 'pl_PL.UTF-8', 'pl_PL.utf8', 'polish', 'pl_PL');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['month']) && isset($_POST['year'])) {
        $month = $_POST['month'];
        $year = $_POST['year'];
        genCalendar($month, $year);
    }

    function genCalendar($month, $year): void {
        $weekDays = ['Pn', 'Wt', 'Śr', 'Czw', 'Pt', 'Sb', 'Nd'];
        $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
        $CountOfDays = date('t', $firstDayOfMonth);

        $months = [
            1 => 'Styczeń', 2 => 'Luty', 3 => 'Marzec', 4 => 'Kwiecień',
            5 => 'Maj', 6 => 'Czerwiec', 7 => 'Lipiec', 8 => 'Sierpień',
            9 => 'Wrzesień', 10 => 'Październik', 11 => 'Listopad', 12 => 'Grudzień'
        ];
        
        $nameOfMonth = $months[$month];
        $startDay = date('N', $firstDayOfMonth);
    
        echo "<table style='text-transform: uppercase;'><tr><th colspan='7'>$nameOfMonth $year</th></tr><tr>";

        foreach ($weekDays as $day) {
            if ($day === 'Nd') {
                echo "<th style='background-color: red; color: white;'>$day</th>";
            } else {
                echo "<th style='background-color: gray; color: white;'>$day</th>";
            }
        }

        echo "</tr><tr>";

        for ($i = 1; $i < $startDay; $i++) {
            echo "<td></td>";
        }

        for ($day = 1; $day <= $CountOfDays; $day++) {
            $currentDayOfWeek = ($startDay + $day - 2) % 7 + 1;

            if ($currentDayOfWeek == 7) {
                echo "<td style='color: red;'>$day</td>";
            } else {
                echo "<td>$day</td>";
            }

            if ($currentDayOfWeek == 7) {
                echo "</tr><tr>";
            }
        }

        echo "</tr></table>";
    }
    ?>
</body>
</html>