<?php
include_once("models/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $name = $connection->real_escape_string($_POST['name']);
    $playtime = (int)$_POST['playtime'];
    $min_age = (int)$_POST['min_age'];
    $min_players = (int)$_POST['min_players'];
    $max_players = (int)$_POST['max_players'];
    $description = $connection->real_escape_string($_POST['description']);
    $sleeves = isset($_POST['sleeves']) ? 1 : 0;
    $premiun = isset($_POST['premiun']) ? 1 : 0;
    $N_A = isset($_POST['N_A']) ? 1 : 0;

    $sql = "UPDATE boardgames SET 
            name = '$name', 
            playtime = $playtime, 
            min_age = $min_age, 
            min_players = $min_players, 
            max_players = $max_players, 
            description = '$description', 
            sleeves = $sleeves, 
            premiun = $premiun, 
            N_A = $N_A 
            WHERE id = $id";

    if ($connection->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Error al actualizar: " . $connection->error;
    }
}
?>
