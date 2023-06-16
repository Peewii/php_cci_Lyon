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

if (!empty($_POST['id']) && hash_equals($_SESSION['token'], $_POST['token'])) {
    $feature = findFeatureById($_POST['id']);

    if (deleteFeature($_POST['id'])) {
        if ($feature) {
            $image = "/app/uploads/features/$feature[image]";

            if (file_exists($image)) {
                unlink($image);
            }
        }

        $_SESSION['messages']['success'] = "Feature supprimée avec succès";
    } else {
        $_SESSION['messages']['error'] = "Une erreur est survenue, try again";
    }
} else {
    $_SESSION['messages']['error'] = "Id non trouvé ou token invalide";
}

header('Location: /admin/features');
exit();
