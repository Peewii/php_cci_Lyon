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

/**
 * Récupère un user en cherchant avec un id
 *
 * @param integer $id Id pour filtrer
 * @return array|bool Tableau assoc avec le User
 */
function findUserById(int $id): array|bool
{
    global $db;

    $query = "SELECT id, prenom, nom, email, roles FROM users WHERE id = :id";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute([
        'id' => $id
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

/**
 * Update user with id for identification
 *
 * @param integer $id Of user to update
 * @param string $prenom Firstname of user
 * @param string $nom Lastname of user
 * @param string $email Email of user
 * @param array $roles Roles of user
 * @return boolean Return true if the query is ok, false if not
 */
function updateUser(int $id, string $prenom, string $nom, string $email, array $roles): bool
{
    global $db;

    try {
        $query = "UPDATE users SET prenom = :prenom, nom = :nom, email = :email, roles = :roles WHERE id = :id";

        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'prenom' => $prenom,
            'nom' => $nom,
            'email' => $email,
            'roles' => json_encode($roles),
            'id' => $id,
        ]);
    } catch (PDOException $e) {
        var_dump($e->getMessage());

        return false;
    }

    return true;
}

/**
 * Delete a user from the database
 *
 * @param integer $id Id of user to delete
 * @return boolean Return true if the query is successfull, false if not
 */
function deleteUser(int $id): bool
{
    global $db;

    try {
        $query = "DELETE FROM users WHERE id = :id";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'id' => $id,
        ]);
    } catch (PDOException $e) {
        var_dump($e->getMessage());

        return false;
    }

    return true;
}
