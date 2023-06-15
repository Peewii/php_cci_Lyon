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

$_SESSION['token'] = bin2hex(random_bytes(35));

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration des users | My first App Php</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
    <link rel="stylesheet" href="/assets/styles/admin.css">
</head>

<body>
    <?php include_once '/app/templates/header.php'; ?>
    <main>
        <?php include_once '/app/templates/messages.php'; ?>
        <section class="container">
            <h1 class="text-center">Administration des users</h1>
            <div class="card-user-list">
                <?php foreach (findAllUser() as $user) : ?>
                    <div class="card card-user">
                        <div class="card-body">
                            <h2><?= "$user[prenom] $user[nom]"; ?></h2>
                            <p><?= $user['email']; ?></p>
                            <p class="text-muted">
                                <?php foreach (json_decode($user['roles'] ?: '["ROLE_USER"]') as $role) : ?>
                                    <?= $role; ?>
                                <?php endforeach; ?>
                            </p>
                            <div class="card-btn">
                                <a href="/admin/users/edit.php?id=<?= $user['id']; ?>" class="btn btn-primary">Modifier</a>
                                <form action="/admin/users/delete.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                    <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                    <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
                                    <button class="btn btn-danger">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</body>

</html>