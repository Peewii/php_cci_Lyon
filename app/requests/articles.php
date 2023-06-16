<?php

include_once '/app/config/mysql.php';

function findAllArticles(): array
{
    global $db;

    $query = "SELECT * FROM articles";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}

function findAllArticlesWithAuthor(): array
{
    global $db;

    $query = "SELECT a.*, u.nom, u.prenom FROM articles a JOIN users u ON u.id = a.user_id ORDER BY a.created_at DESC";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}
/**
 * Undocumented function
 *
 * @param integer $id
 * @return void
 */
function findArticlesById(int $id): array | bool
{
    global $db;

    $query = "SELECT * FROM articles WHERE id = :id";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute([
        'id' => $id,
    ]);

    return $sqlStatement->fetch();
}
function createArticle(
    int $userId,
    string $titre,
    string $contenu,
    string $image,
    ?int $actif = 0,
    ?string $metaTitle = null,
    ?string $metaDesc = null,
): bool {
    global $db;

    try {
        $query = "INSERT INTO articles(user_id, titre, contenu, image, actif, meta_title, meta_description) VALUES (:userId, :titre, :contenu, :image, :actif, :metaTitle, :metaDesc)";

        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'userId'    => $userId,
            'titre'     => $titre,
            'contenu'   => $contenu,
            'image'     => $image,
            'actif'     => $actif,
            'metaTitle' => $metaTitle,
            'metaDesc'  => $metaDesc,

        ]);
    } catch (PDOException $e) {
        var_dump($e->getMessage());
        return false;
    }

    return true;
}
