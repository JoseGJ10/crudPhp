<?php
include_once("models/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "DELETE FROM boardgames WHERE id = $id";

    if ($connection->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $connection->error]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>