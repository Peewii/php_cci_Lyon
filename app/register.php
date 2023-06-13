<?php

session_start();

include_once '/app/requests/users.php';

if (
    !empty($_POST['prenom']) &&
    !empty($_POST['nom']) &&
    !empty($_POST['email']) &&
    !empty($_POST['password'])
) {
    // Nettoyer nos données
    $prenom = strip_tags($_POST['prenom']);
    $nom = htmlspecialChars($_POST['nom']);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    // Vérifie si l'email saisi éxiste en BDD
    if (!findUserByEmail($email)) {
        // Si l'email n'existe pas en BDD, on crée l'utilisateur en base
        $user = createUser($prenom, $nom, $email, password_hash($password, PASSWORD_ARGON2I));

        if ($user) {
            header("Location: /login.php");
            exit();
        } else {
            $errorMessage = "Une erreur est survenue, try again";
        }
    } else {
        $errorMessage = "Cet email est déjà existant, veuillez vous connecter";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | My first App Php</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
    <?php include_once './templates/header.php'; ?>
    <main>
        <section class="container">
            <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="POST" class="form">
                <h1 class="text-center">S'inscrire</h1>

                <?php if (!empty($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <p><?= $errorMessage; ?></p>
                    </div>
                <?php endif; ?>

                <div class="form-row">
                    <div class="form-group">
                        <label for="nom">Votre Nom:</label>
                        <input type="text" name="nom" id="nom" placeholder="Doe">
                    </div>
                    <div class="form-group">
                        <label for="prenom">Votre prénom:</label>
                        <input type="text" name="prenom" id="prenom" placeholder="John">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Votre email:</label>
                    <input type="email" name="email" id="email" placeholder="john@exemple.com">
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe:</label>
                    <input type="password" name="password" id="password" placeholder="S3CR3T">
                </div>
                <button class="btn btn-primary">Envoyer</button>
            </form>
        </section>
    </main>
</body>

</html>