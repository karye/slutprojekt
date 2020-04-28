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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="kontainer">
        <h1 class="display-4">Bloggen</h1>
        <nav>
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link" href="./lasa.php">Läsa</a></li>
                <li class="nav-item"><a class="nav-link" href="./skriva.php">Skriva</a></li>
                <li class="nav-item"><a class="nav-link active" href="./lista.php">Admin</a></li>
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
            echo "<table>";
            echo "<tr><th>Datum</th><th>Rubrik</th><th>Inlägg</th><th colspan=\"2\">Handling</th></tr>";
            while ($rad = $result->fetch_assoc()) {
                $snippet = mb_substr($rad[inlagg], 0, 30) . "...";
                echo "<tr>
                    <td>$rad[datum]</td>
                    <td>$rad[rubrik]</td>
                    <td>$snippet</td>
                    <td><a class=\"alert alert-warning\" href=\"redigera.php?id=$rad[id]\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a></td>
                    <td><a class=\"alert alert-danger\" href=\"radera.php?id=$rad[id]\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a></td>
                    </tr>";
            }
            echo "</table>";

            /* 4. Stäng ned anslutningen */
            $conn->close();
            ?>
        </main>
    </div>
</body>
</html>