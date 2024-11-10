<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz rejestracyjny</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

    <div class="block1">
        <form id="user_form" method="POST" class="form">
            <h2>Rejestracja użytkownika</h2>

            <div class="form-group">
                <label for="username">Imię:</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="date">Data urodzenia:</label>
                <input type="date" name="date" required>
            </div>

            <div class="form-group">
                <input type="submit" name="register_user" value="Zatwierdź">
            </div>

            <?php 
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_user'])) {
                if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['date'])) {
                    $conn = mysqli_connect('localhost', 'root', '', 'database');
                    if (!$conn) {
                        die("Błąd połączenia: " . mysqli_connect_error());
                    }

                    $username = mysqli_real_escape_string($conn, $_POST['username']);
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $date = mysqli_real_escape_string($conn, $_POST['date']);

                    $check_email = "SELECT * FROM users WHERE email = '$email'";
                    $result_check_email = mysqli_query($conn, $check_email);

                    if (mysqli_num_rows($result_check_email) > 0) {
                        echo "<p class='error'>Taki adres email już istnieje</p>";
                    } else {
                        $sql_users = "INSERT INTO users (imie, email, data_urodzenia) VALUES ('$username', '$email', '$date')";
                        if (mysqli_query($conn, $sql_users)) {
                            echo "<p class='success'>Rejestracja użytkownika zakończona sukcesem!</p>";
                        } else {
                            echo "<p class='error'>Błąd: " . mysqli_error($conn) . "</p>";
                        }
                    }

                    mysqli_close($conn);
                }
            }
            ?>
        </form>

        <form id="company_form" method="POST" class="form">
            <h2>Rejestracja firmy</h2>

            <div class="form-group">
                <label for="company_name">Nazwa firmy:</label>
                <input type="text" name="company_name" required>
            </div>

            <div class="form-group">
                <label for="company_email">Email:</label>
                <input type="email" name="company_email" required>
            </div>

            <div class="form-group">
                <label for="company_nip">NIP:</label>
                <input type="text" name="company_nip" pattern="^[0-9]{10}$" maxlength="10" required title="NIP musi składać się z dokładnie 10 cyfr">
            </div>

            <div class="form-group">
                <input type="submit" name="register_company" value="Zatwierdź">
            </div>
            
            <?php 
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_company'])) {
                if (!empty($_POST['company_name']) && !empty($_POST['company_email']) && !empty($_POST['company_nip'])) {
                    $conn = mysqli_connect('localhost', 'root', '', 'database');

                    if (!$conn) {
                        die("Błąd połączenia: " . mysqli_connect_error());
                    }

                    $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
                    $company_email = mysqli_real_escape_string($conn, $_POST['company_email']);
                    $company_nip = mysqli_real_escape_string($conn, $_POST['company_nip']);

                    $check_company_name = "SELECT * FROM company WHERE nazwa_firmy = '$company_name'";
                    $check_company_email = "SELECT * FROM company WHERE email = '$company_email'";
                    $check_company_nip = "SELECT * FROM company WHERE nip = '$company_nip'";

                    $result_check_company_name = mysqli_query($conn, $check_company_name);
                    $result_check_company_email = mysqli_query($conn, $check_company_email);
                    $result_check_company_nip = mysqli_query($conn, $check_company_nip);

                    if (mysqli_num_rows($result_check_company_name) > 0) {
                        echo "<p class='error'>Firma z taką nazwą już istnieje</p>";
                    } else if (mysqli_num_rows($result_check_company_email) > 0) {
                        echo "<p class='error'>Firma z takim adresem email już istnieje</p>";
                    } else if (mysqli_num_rows($result_check_company_nip) > 0) {
                        echo "<p class='error'>Firma z takim NIP'em już istnieje</p>";
                    } else {
                        $sql_company = "INSERT INTO company (nazwa_firmy, email, nip) VALUES ('$company_name', '$company_email', '$company_nip')";
                        if (mysqli_query($conn, $sql_company)) {
                            echo "<p class='success'>Rejestracja firmy zakończona sukcesem!</p>";
                        } else {
                            echo "<p class='error'>Błąd: " . mysqli_error($conn) . "</p>";
                        }
                    }

                    mysqli_close($conn);
                } else {
                    echo "<p class='error'>Wszystkie pola są wymagane.</p>";
                }
            }
            ?>
        </form>
    </div>
</body>
</html>