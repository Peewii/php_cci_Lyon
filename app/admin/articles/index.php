<?php

session_start();

include_once '/app/requests/articles.php';

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
    <title>Administration des articles | My first App Php</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
    <link rel="stylesheet" href="/assets/styles/admin.css">
</head>

<body>
    <?php include_once '/app/templates/header.php'; ?>
    <main>
        <?php include_once '/app/templates/messages.php'; ?>
        <section class="container">
            <h1 class="text-center">Administration des articles </h1>
            <a href="/admin/articles/create.php" class="btn btn-primary">Créer un article</a>
            <div class="card-user-list">
                <?php foreach (findAllArticlesWithAuthor() as $article) : ?>
                    <div class="card card-user">
                        <img class="card-img" src="/uploads/articles/<?= $article['image']; ?>" alt="<?= $article['titre']; ?>" loading="lazy">
                        <div class="card-body">
                            <h2 class="text-center"><?= $article['titre']; ?></h2>
                            <p class="test-muted"><?= date_format(new Datetime($article['created_at']), 'd/m/Y'); ?></p>
                            <p><?= strlen($article['contenu']) > 150 ? substr($article['contenu'], 0, 150) . '...' : $article['contenu']; ?></p>
                            <p class="<?= $article['actif'] ? 'text-success' : 'text-danger'; ?>"><?= $article['actif'] ? 'Actif' : 'Innactif'; ?></p>
                            <p class="text-muted"><?= "$article[prenom] $article[nom]"; ?></p>
                            <div class="card-btn">
                                <a href="/admin/articles/edit.php?id=<?= $article['id']; ?>" class="btn btn-primary">Modifier</a>
                                <form action="/admin/articles/delete.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette article ?')">
                                    <input type="hidden" name="id" value="<?= $article['id']; ?>">
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