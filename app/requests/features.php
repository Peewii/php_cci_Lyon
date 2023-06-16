<?php

include_once '/app/config/mysql.php';

/**
 * Find all the feature in DB
 *
 * @return array
 */
function findAllFeatures(): array
{
    global $db;

    $query = "SELECT * FROM features ORDER BY nom ASC";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}

/**
 * Find One feature by id
 *
 * @param integer $id
 * @return array|boolean
 */
function findFeatureById(int $id): array|bool
{
    global $db;

    $query = "SELECT * FROM features WHERE id = :id";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute([
        'id' => $id,
    ]);

    return $sqlStatement->fetch();
}

/**
 * Create a feature in DB
 *
 * @param string $nom
 * @param string $image
 * @return boolean
 */
function createFeature(string $nom, string $image): bool
{
    global $db;

    try {
        $query = "INSERT INTO features(nom, image) VALUES (:nom, :image)";

        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'nom' => $nom,
            'image' => $image,
        ]);
    } catch (PDOException $e) {
        var_dump($e->getMessage());

        return false;
    }

    return true;
}

/**
 * Update a feature in DB
 *
 * @param integer $id
 * @param string $nom
 * @param string|null $image
 * @return boolean
 */
function updateFeature(int $id, string $nom, ?string $image = null): bool
{
    global $db;

    try {
        if ($image) {
            $query = "UPDATE features SET nom = :nom, image = :image WHERE id = :id";

            $sqlStatement = $db->prepare($query);
            $sqlStatement->execute([
                'nom' => $nom,
                'image' => $image,
                'id' => $id,
            ]);
        } else {
            $query = "UPDATE features SET nom = :nom WHERE id = :id";

            $sqlStatement = $db->prepare($query);
            $sqlStatement->execute([
                'nom' => $nom,
                'id' => $id,
            ]);
        }
    } catch (PDOException $e) {
        var_dump($e->getMessage());

        return false;
    }

    return true;
}

/**
 * Delete a feature in DB
 *
 * @param integer $id
 * @return boolean
 */
function deleteFeature(int $id): bool
{
    global $db;

    try {
        $query = "DELETE FROM features WHERE id = :id";
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
