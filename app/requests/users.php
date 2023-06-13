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

function createUser(string $prenom, string $nom, string $email, string $password): bool
{
    global $db;

    try {
        $query = "INSERT INTO users(prenom, nom, email, password) VALUES (:prenom, :nom, :email, :password)";

        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'prenom'    => $prenom,
            'nom'       => $nom,
            'email'     => $email,
            'password'  => $password,
        ]);
    } catch (PDOException $e) {
        var_dump($e->getMessage());

        return false;
    }

    return true;
}
