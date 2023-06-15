<?php

session_start();

include_once '/app/requests/users.php';

// On vérifie si l'utilisateur est connecté et qu'il est admin
if (!in_array('ROLE_ADMIN', isset($_SESSION['LOGGED_USER']) ? $_SESSION['LOGGED_USER']['roles'] : [])) {
    $_SESSION['messages']['error'] = 'Vous devez être connecté en admin pour accéder à cette page';

    http_response_code(403);
    header('Location: /login.php');
    exit();
}

// On récupère l'utillisateur à modifier avec le paramètre get de l'url
$user = findUserById(isset($_GET['id']) ? (int) $_GET['id'] : 0);

// On vérifie si l'utilisateur existe
if (!$user) {
    $_SESSION['messages']['error'] = "L'utilisateur n'existe pas";

    http_response_code(404);
    header('Location: /admin/users');
    exit();
}

// On vérifie le formulaire
if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email'])) {
    // On nettoie les données
    $nom = strip_tags($_POST['nom']);
    $prenom = strip_tags($_POST['prenom']);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $roles = $_POST['roles'];

    if (updateUser($user['id'], $prenom, $nom, $email, $roles)) {
        $_SESSION['messages']['success'] = "Utilisateur modifié avec succès";

        header('Location: /admin/users');
        exit();
    } else {
        $errorMessage = "Une erreur est survenue, try again";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification d'un user | My first App Php</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
    <?php include_once '/app/templates/header.php'; ?>
    <main>
        <?php include_once '/app/templates/messages.php'; ?>
        <section class="container">
            <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="POST" class="form">
                <h1 class="text-center">Modification d'un user</h1>
                <?php if (!empty($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <p><?= $errorMessage; ?></p>
                    </div>
                <?php endif; ?>
                <div class="form-row">
                    <div class="form-group">
                        <label for="nom">Votre Nom:</label>
                        <input type="text" name="nom" id="nom" placeholder="Doe" value="<?= $user['nom']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="prenom">Votre prénom:</label>
                        <input type="text" name="prenom" id="prenom" placeholder="John" value="<?= $user['prenom']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Votre email:</label>
                    <input type="email" name="email" id="email" placeholder="john@exemple.com" value="<?= $user['email']; ?>">
                </div>
                <div class="form-group">
                    <label for="roles">Roles:</label>
                    <select name="roles[]" id="roles">
                        <option value="ROLE_USER">Sélectionner une valeur</option>
                        <option value="ROLE_USER">Utilisateur</option>
                        <option value="ROLE_EDITOR" <?= in_array('ROLE_EDITOR', json_decode($user['roles'] ?: '[]')) ? 'selected' : null; ?>>Éditeur</option>
                        <option value="ROLE_ADMIN" <?= in_array('ROLE_ADMIN', json_decode($user['roles'] ?: '[]')) ? 'selected' : null; ?>>Administrateur</option>
                    </select>
                </div>
                <button class="btn btn-primary">Modifier</button>
            </form>
            <a href="/admin/users" class="btn btn-secondary mt-2">Retour à la liste</a>
        </section>
    </main>
</body>

</html>