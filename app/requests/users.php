<?php

// On inclut le fichier qui fait la connexion en BDD pour avoir accès
// à la variable $db qui stocke la connexion en BDD
include_once '/app/config/mysql.php';

/**
 * Récupérer toutes les entrées de la table user
 *
 * @return array
 */
function findAllUser(): array
{
    // On définit $db pour recherche variable globale
    global $db;

    // On définit notre requête SQL
    $query = "SELECT * FROM users";
    // On prépare la requête SQL
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}

/**
 * Récupère un user en cherchant avec un email
 *
 * @param string $email Email pour filtrer
 * @return array|bool Tableau assoc avec le User
 */
function findUserByEmail(string $email): array|bool
{
    global $db;

    $query = "SELECT * FROM users WHERE email = :email";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute([
        'email' => $email
    ]);

    return $sqlStatement->fetch();
}
