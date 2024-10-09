<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../models/article.class.php";

try {
    $articles = new Article();
    $records = $articles->commandes();

    header('Content-Type: application/json');
    echo json_encode($records);
} catch (Exception $e) {
    header('Content-Type: application/json', true, 500);
    echo json_encode(['error' => $e->getMessage()]);
}

?>
