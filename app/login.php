<?php

session_start();

include_once '/app/requests/users.php';

// On vérifie que le formulaire est envoyé et que les champs ne sont pas vides
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // On essaie de récupérer un user en BDD avec l'email saisi dans le form
    $verifUser = findUserByEmail($email);

    // On vérifie que l'utilisateur existe et que le mot de passe est bon
    if ($verifUser && $verifUser['password'] == $password) {
        // On connecte l'utilisateur
        $_SESSION['LOGGED_USER'] = [
            'id' => $verifUser['id'],
            'email' => $verifUser['email'],
            'prenom' => $verifUser['prenom'],
            'nom' => $verifUser['nom'],
            'roles' => json_decode($verifUser['roles']),
        ];

        // On redirige l'utilisateur vers la page d'accueil
        header('Location: /');
        exit();
    } else {
        $errorMessage = 'Identifiants incorrects';
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | My first App Php</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
    <?php include_once './templates/header.php'; ?>
    <main>
        <section class="container">
            <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="POST" class="form form-login">
                <h1 class="text-center">Connexion</h1>

                <?php if (!empty($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <p><?= $errorMessage; ?></p>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="email">Votre email:</label>
                    <input type="email" name="email" id="email" placeholder="john@exemple.com">
                </div>
                <div class="form-group">
                    <label for="password">Votre mot de passe:</label>
                    <input type="password" name="password" id="password" placeholder="********">
                </div>
                <button type="submit" class="btn btn-primary">Connexion</button>
            </form>
        </section>
    </main>
</body>

</html>