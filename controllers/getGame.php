<?php

include_once("../models/connection.php");

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $result = $connection->query("SELECT * FROM boardgames WHERE id = $id");
        $game = $result->fetch_assoc();

        if ($game) {
            echo json_encode(['success' => true, 'game' => $game]);
        } else {
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false]);
    }

?>