<?php
    session_start();

    if (isset($_SESSION["user"])) {
        extract($_SESSION["user"]);
    } else {
        header("Refresh: 0; URL=/connexion.php?from=planning");
        die;
    }

    if (!isset($_GET["id"])) {
        header("Refresh: 0; URL=/planning.php");
        die;
    }

    $db = new mysqli("localhost", "root", "", "reservationsalles");

    $request = "SELECT * FROM reservations WHERE id = ?";
    $stmt = $db->prepare($request);
    $stmt->bind_param("i", $_GET["id"]);
    $stmt->execute();
    $events = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    if (count($events) < 1) {
        header("Refresh: 0; URL=/planning.php");
        die;
    }

    $event = $events[0];
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Réservation</title>
</head>
<body>
    <header>
        <h1>Réservation de salles</h1>
        <a href="/planning.php">Retour</a>
    </header>
    <main id="reservation">
        <p><strong>Titre</strong>: <?= $event["titre"] ?></p>
        <p><strong>Description</strong>: <?= $event["description"] ?></p>
        <p><strong>Date de début</strong>: <?= $event["debut"] ?></p>
        <p><strong>Date de fin</strong>: <?= $event["fin"] ?></p>
    </main>
</body>
</html>