<?php

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
            move_uploaded_file($_FILES['image']['tmp_name'], '/app/uploads/' . $fileInfo['filename'] . date('d-m-Y_H:i:s') . '.' . $fileExtension);
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
    <title>Contact | My first App Php</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
    <?php include_once './templates/header.php'; ?>
    <main>
        <section class="container">
            <?php if (!empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['age'])) : ?>
                <h1>Bonjour <?= strip_tags($_POST['prenom']) . ' ' . strip_tags($_POST['nom']); ?></h1>
                <p>Vous avez <?= strip_tags($_POST['age']); ?> ans.</p>
            <?php else : ?>
                <div class="alert alert-danger">
                    <p>Vous n'avez pas soumis le formulaire sur la page d'accueil.</p>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>

</html>