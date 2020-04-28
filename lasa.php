<?php
/*
* PHP version 7
* @category   Blogg med lagring i databas
* @author     Karim Ryde <karye.webb@gmail.com>
* @license    PHP CC
*/
session_start();
include_once "./konfig-db.php";
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bloggen</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="kontainer">
        <h1 class="display-4">Bloggen</h1>
        <nav>
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" href="./lasa.php">Läsa</a></li>
                <li class="nav-item"><a class="nav-link" href="./skriva.php">Skriva</a></li>
                <li class="nav-item"><a class="nav-link" href="./lista.php">Admin</a></li>
            </ul>
        </nav>
        <main>
            <?php
            /* 1. Logga in på mysql-servern och välj databas */
            $conn = new mysqli($host, $användare, $lösenord, $databas);

            /* Gick det ansluta? */
            if ($conn->connect_error) {
                die("Kunde inte ansluta till databasen: " . $conn->connect_error);
            } else {
                // echo "<p>Yipee! Gick bra att ansluta.</p>";
            }

            /* 2. Ställ en SQL-fråga */
            $sql = "SELECT * FROM blog";
            $result = $conn->query($sql);

            /* Gick det bra? */
            if (!$result) {
                die("Något blev fel med SQL-satsen.");
            } else {
                // echo "<p>Lista på bilar kunde hämtas.</p>";
            }
            
            /* 3. Ta emot svaret och bearbeta det */
            while ($rad = $result->fetch_assoc()) {
                echo "<div class=\"inlagg\">";
                echo "<h5>$rad[rubrik]</h5>";
                echo "<h6>$rad[datum]</h6>";
                echo "<p>$rad[inlagg]</p>";
                echo "</div>";
            }

            /* 4. Stäng ned anslutningen */
            $conn->close();
            ?>
        </main>
    </div>
</body>
</html>