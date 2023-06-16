<?php

session_start();

include_once '/app/requests/articles.php';


// On vérifie si l'utilisateur est connecté et qu'il est admin
if (!in_array('ROLE_ADMIN', isset($_SESSION['LOGGED_USER']) ? $_SESSION['LOGGED_USER']['roles'] : [])) {
    $_SESSION['messages']['error'] = 'Vous devez être connecté en admin pour accéder à cette page';

    http_response_code(403);
    header('Location: /login.php');
    exit();
}

if (
    !empty($_POST['titre']) &&
    !empty($_POST['contenu']) &&
    !empty($_FILES['image'])
) {
    $titre = strip_tags($_POST['titre']);
    $contenu = htmlspecialchars($_POST['contenu']);
    $metaTitle = isset($_POST['meta_title']) ? strip_tags($_POST['meta_title']) : null;
    $metaDesc = isset($_POST['meta_Desc']) ? strip_tags($_POST['meta_Desc']) : null;
    $actif = isset($_POST['actif']) ? 1 : 0;

    // On vérifie l'image est soumise et qu'il n'y a pas d'erreur
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        // On vérifie que le fichie ne dépasse pas 8Mo
        if ($_FILES['image']['size'] <= 8000000) {
            // On vérifie l'extension du fichier
            $fileInfo = pathinfo($_FILES['image']['name']);
            $fileExtension = $fileInfo['extension'];
            $extensionAllowed = ['png', 'jpg', 'jpeg', 'gif', 'webm', 'webp'];

            if (in_array($fileExtension, $extensionAllowed)) {
                // On déplace le fichier dans le dossier uploads
                $image = $fileInfo['filename'] . date('d-m-Y_H:i:s') . '.' . $fileExtension;

                move_uploaded_file($_FILES['image']['tmp_name'], '/app/uploads/articles/' . $image);
            }
        }
    }

    if (createArticle($_SESSION['LOGGED_USER']['id'], $titre, $contenu, $image, $actif, $metaTitle, $metaDesc)) {
        $_SESSION['messages']['succes'] = "Article créé avec succès";

        header('location: /admin/articles');
        exit();
    } else {
        $errorMessage = "Une erreure est survenue, merci de réessayer";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
    $errorMessage = "Veuillez remplir les informations";
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'un article | My first App Php</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
    <link rel="stylesheet" href="/assets/styles/admin.css">
</head>

<body>
    <?php include_once '/app/templates/header.php'; ?>
    <main>
        <?php include_once '/app/templates/messages.php'; ?>
        <section class="container">
            <form action="<?= $_SERVER['REQUEST_URI']; ?>" class="form" method="POST" enctype="multipart/form-data">
                <h1 class="text-center">Création d'un article</h1>
                <?php if (isset($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <p><?= $errorMessage; ?></p>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="titre">Titre:</label>
                    <input type="text" name="titre" id="titre" placeholder="titre de l'article">
                </div>
                <div class="form-row">
                    <div class="form-group w-50">
                        <label for="metaTitle">Méta Titre:</label>
                        <input type="text" name="metaTitle" id="metaTitle" placeholder="titre de la page l'article">
                    </div>
                    <div class="form-group w-50">
                        <label for="metaDesc">Méta Description</label>
                        <input type="text" name="metaDesc" id="metaDesc" placeholder="Méta descritpion de l'article">
                    </div>
                </div>

                <div class="form-group">
                    <label for="contenu">Contenu</label>
                    <textarea name="contenu" id="contenu" rows="10" placeholder="contenu de l'article"></textarea>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="actif" id="actif">
                    <label for="actif">Actif</label>
                </div>
                <div class="form-group">
                    <label for="image">image:</label>
                    <input type="file" name="image" id="image">
                </div>
                <button class="btn btn-primary">Créer</button>
            </form>
            <a href="/admin/articles" class="btn btn-secondary mt-2">Retour à la liste</a>
        </section>
    </main>
</body>