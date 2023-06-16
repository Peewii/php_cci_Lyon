<?php

session_start();

include_once '/app/requests/features.php';

// On vérifie si l'utilisateur est connecté et qu'il est admin
if (!in_array('ROLE_ADMIN', isset($_SESSION['LOGGED_USER']) ? $_SESSION['LOGGED_USER']['roles'] : [])) {
    $_SESSION['messages']['error'] = 'Vous devez être connecté en admin pour accéder à cette page';

    http_response_code(403);
    header('Location: /login.php');
    exit();
}

$feature = findFeatureById(isset($_GET['id']) ? (int) $_GET['id'] : 0);

if (!$feature) {
    $_SESSION['messages']['error'] = "Feature non trouvée";

    header('Location: /admin/features');
    exit();
}

if (!empty($_POST['nom'])) {
    $nom = strip_tags($_POST['nom']);

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

                move_uploaded_file($_FILES['image']['tmp_name'], '/app/uploads/features/' . $image);

                $oldImage = "/app/uploads/features/$feature[image]";

                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }
        }
    }

    if (updateFeature($feature['id'], $nom, isset($image) ? $image : null)) {
        $_SESSION['messages']['success'] = "Feature modifiée avec succès";

        header("Location: /admin/features");
        exit();
    } else {
        $errorMessage = "Une erreur est survenue, try again";
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
    <title>Modification d'une feature | My first App Php</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
    <link rel="stylesheet" href="/assets/styles/admin.css">
</head>

<body>
    <?php include_once '/app/templates/header.php'; ?>
    <main>
        <?php include_once '/app/templates/messages.php'; ?>
        <section class="container">
            <form action="<?= $_SERVER['REQUEST_URI']; ?>" class="form" method="POST" enctype="multipart/form-data">
                <h1 class="text-center">Modification d'une feature</h1>
                <?php if (isset($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <p><?= $errorMessage; ?></p>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="nom">Nom:</label>
                    <input type="text" name="nom" id="nom" placeholder="Nom de la feature" value="<?= $feature['nom']; ?>">
                </div>
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" name="image" id="image">
                </div>
                <img class="img-form" src="/uploads/features/<?= $feature['image']; ?>" alt="<?= $feature['nom']; ?>" loading="lazy">
                <button class="btn btn-primary">Modifier</button>
            </form>
            <a href="/admin/features" class="btn btn-secondary mt-2">Retour à la liste</a>
        </section>
    </main>
</body>

</html>