<?php

session_start();

include_once '/app/requests/users.php';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage | My first App Php</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
    <?php include_once './templates/header.php'; ?>
    <main>
        <?php include_once './templates/messages.php'; ?>
        <section class="container">
            <form action="/contact.php" method="POST" class="form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nom">Votre Nom:</label>
                    <input type="text" name="nom" id="nom" placeholder="Doe">
                </div>
                <div class="form-group">
                    <label for="prenom">Votre prénom:</label>
                    <input type="text" name="prenom" id="prenom" placeholder="John">
                </div>
                <div class="form-group">
                    <label for="age">Votre age:</label>
                    <input type="number" name="age" id="age" placeholder="30">
                </div>
                <div class="form-group">
                    <label for="image">Votre image:</label>
                    <input type="file" name="image" id="image">
                </div>
                <button class="btn btn-primary">Envoyer</button>
            </form>
        </section>
    </main>
</body>

</html>