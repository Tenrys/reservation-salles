<?php
    require "util.php";

    session_start();

    if (!isset($_SESSION["user"])) {
        header("Location: index.php");
        die;
    }

    if (!isset($_GET["debut"])) {
        header("Location: planning.php");
        die;
    }

    extract($_POST);
    extract($_GET);

    // On regarde si quelqu'un essaie de faire n'importe quoi avec le temps...
    $debutTemps = strtotime($debut);
    if ($debutTemps < strtotime("monday this week 00:00") || $debutTemps > strtotime("friday this week 23:59")) {
        header("Location: planning.php");
        die;
    }
    $debutInfo = getdate($debutTemps);
    if ($debutInfo["hours"] < 8 || $debutInfo["hours"] > 19 || $debutInfo["seconds"] != 0 || $debutInfo["minutes"] != 0) {
        header("Location: planning.php");
        die;
    }

    $fin = date("Y-m-d\TH:i", $debutTemps + 60 * 60);

    $debutDatetime = strtodatetime($debut);
    $finDatetime = strtodatetime($fin);

    $db = new mysqli("localhost", "root", "", "reservationsalles");

    $request = "SELECT * FROM reservations WHERE debut BETWEEN ? AND ?";
    $stmt = $db->prepare($request);
    $stmt->bind_param("ss", $debutDatetime, $finDatetime);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    if (count($result) > 0) {
        $_SESSION["error"] = "Il y a déjà un évenement prévu pendant cette période";
        header("Location: planning.php");
        die;
    }

    if (count($_POST) > 0) {
        $request = "INSERT INTO reservations (titre, description, debut, fin, id_utilisateur) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($request);
        $stmt->bind_param("ssssi", $titre, $description, $debutDatetime, $finDatetime, $_SESSION["user"]["id"]);
        $stmt->execute();

        header("Location: planning.php");
        die;
    }
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Formulaire de réservation</title>
</head>
<body>
    <header>
        <h1>Réservation de salles</h1>
        <a href="planning.php">Retour</a>
    </header>
    <main id="reservation-form">
        <form method="post">
            <div class="columns">
                <div class="column">
                    <label for="titre">Titre</label>
                    <input type="text" name="titre" required minlength="3" maxlength="255" value="<?= $titre ?? '' ?>">
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <label for="description">Description</label>
                    <textarea name="description" maxlength="65536"><?= $description ?? '' ?></textarea>
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <label for="debut">Date de début</label>
                    <input type="datetime-local" name="debut" required readonly value="<?= $debut ?? '' ?>">
                </div>

                <div class="column">
                    <label for="fin">Date de fin</label>
                    <input type="datetime-local" name="fin" required readonly value="<?= $fin ?? '' ?>">
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <input type="submit" value="Enregistrer">
                </div>
            </div>
        </form>
    </main>
</body>
</html>