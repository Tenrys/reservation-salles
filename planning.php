<?php
    require "util.php";

    session_start();

    if (isset($_SESSION["user"])) {
        extract($_SESSION["user"]);
    }

    $weekdays = [
        "monday",
        "tuesday",
        "wednesday",
        "thursday",
        "friday"
    ];

    $db = new mysqli("localhost", "root", "", "reservationsalles");

    $request = sprintf("SELECT * FROM reservations WHERE debut BETWEEN '%s' AND '%s'", strtodatetime("monday this week 00:00"), strtodatetime("friday this week 23:59"));

    $query = $db->query($request);
    $events = $query->fetch_all(MYSQLI_ASSOC);

    function fetchEvent($time) {
        global $db;
        global $events;

        foreach ($events as $event) {
            $debut = strtotime($event["debut"]);
            $fin = strtotime($event["fin"]);
            if ($time == $debut && $time <= $fin) {
                $request = "SELECT login FROM utilisateurs WHERE id = ?";

                $stmt = $db->prepare($request);
                $stmt->bind_param("s", $event["id_utilisateur"]);
                $stmt->execute();
                $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

                echo "<a class='event' href='reservation.php?id={$event['id']}'>";
                echo "<h3>{$event['titre']}</h3>";
                echo "Créé par {$result['0']['login']}";
                echo "</a>";
                return;
            }
        }

        if (!isset($_SESSION["user"])) return;

        echo "<a class='create-event' href='reservation-form.php?debut=" . date("Y-m-d\TH:i", $time) . "'>";
        echo "<span>+</span>";
        echo "</a>";
    }
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">
        <title>Planning</title>
    </head>

    <body>
        <header>
            <h1>Réservation de salles</h1>
            <a href="/">Retour</a>
        </header>
        <main id="planning">
            <h2>Voici les événements pour cette semaine... Vous pouvez en planifier un si vous êtes connecté.</h2>
            <?php
                if (isset($_SESSION["error"])) {
                    echo "<h4 class='error'>{$_SESSION['error']}</h4>";
                    unset($_SESSION["error"]);
                }
            ?>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Lundi <?= strtodatetime("monday this week", "j") ?></th>
                        <th>Mardi <?= strtodatetime("tuesday this week", "j") ?></th>
                        <th>Mercredi <?= strtodatetime("wednesday this week", "j") ?></th>
                        <th>Jeudi <?= strtodatetime("thursday this week", "j") ?></th>
                        <th>Vendredi <?= strtodatetime("friday this week", "j") ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 8; $i < 20; $i++) {
                        ?>
                        <tr>
                            <td><?= strval($i) . "h - " . strval($i + 1) . "h" ?></td>
                            <?php
                            for ($i2 = 0; $i2 < 5; $i2++) {
                                ?>
                                <td><?= fetchEvent(strtotime(
                                    $weekdays[$i2] . " this week " . str_pad($i, 2, '0', STR_PAD_LEFT) . ":00"
                                )) ?></td>
                                <?php
                            }
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </body>
</html>