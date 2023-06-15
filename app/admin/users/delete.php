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

if (!empty($_POST['id']) && hash_equals($_SESSION['token'], $_POST['token'])) {
    if (deleteUser($_POST['id'])) {
        $_SESSION['messages']['success'] = "Utilisateur supprimé avec succès";
    } else {
        $_SESSION['messages']['error'] = "Une erreur est survenue, try again";
    }
} else {
    $_SESSION['messages']['error'] = "Id ou token invalide";
}

header("Location: /admin/users");
exit();
