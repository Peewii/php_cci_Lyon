<?php

session_start();

$users = [
    [
        'email' => 'pierre@test.com',
        'password' => '1234',
    ],
    [
        'email' => 'john@test.com',
        'password' => '1234',
    ]
];

// On vérifie que le formulaire est envoyé et que les champs ne sont pas vides
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // On parcours le tableau des utilisateurs
    foreach ($users as $user) {
        // On vérifie que l'email et le mot de passe correspondent
        if ($user['email'] === $email && $user['password'] === $password) {
            // On peut connecter l'utilisateur
            $_SESSION['LOGGED_USER'] = [
                'email' => $user['email'],
            ];

            break;
        }
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
            <?php if (!empty($_SESSION['LOGGED_USER'])) : ?>
                <div class="alert alert-success">
                    <p>Vous êtes connecté avec l'email <?= $_SESSION['LOGGED_USER']['email']; ?></p>
                </div>
            <?php endif; ?>

            <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="POST" class="form form-login">
                <h1 class="text-center">Connexion</h1>
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