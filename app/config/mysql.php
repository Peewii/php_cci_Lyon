<?php

try {
    $db = new PDO(
        'mysql:host=phpccilyon-db-1;dbname=demo_php;charset=utf8',
        'root',
    );

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die($e->getMessage());
}
