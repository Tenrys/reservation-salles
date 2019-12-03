<?php
    session_start();

    if (isset($_SESSION["user"])) {
        header("Location: index.php");
        die;
    }

    if (count($_POST) > 0) {
        extract($_POST);

        $db = new mysqli("localhost", "root", "", "reservationsalles");

        $request = "SELECT * FROM utilisateurs WHERE login = ?;";
        $stmt = $db->prepare($request);
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        if (count($results) > 0 && password_verify($password, $results[0]["password"])) {
            $_SESSION["user"] = $results[0];
            if (isset($_GET["from"])) {
                header("Location: {$_GET['from']}.php");
            } else {
                header("Location: index.php");
            }
            die;
        } else {
            $error = "Mot de passe incorrect !";
        }
    }
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">
        <title>Connexion</title>
    </head>

    <body>
        <header>
            <h1>Réservation de salles</h1>
            <a href="index.php">Retour</a>
        </header>
        <main id="connexion">
            <h2>Connexion</h2>
            <?php
            if (isset($error)) {
                echo "<h4 class='error'>$error</h4>";
            }
            ?>
            <form method="post">
                <div class="columns">
                    <div class="column">
                        <label for="login">Login</label>
                        <input type="text" name="login" required minlength="3" maxlength="255" value="<?= $login ?? '' ?>">
                    </div>
                </div>

                <div class="columns">
                    <div class="column">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" required minlength="3" maxlength="255" value="<?= $password ?? '' ?>">
                    </div>
                </div>

                <div class="columns">
                    <div class="column">
                        <input type="submit" value="Se connecter">
                    </div>
                </div>
            </form>
        </main>
    </body>
</html>