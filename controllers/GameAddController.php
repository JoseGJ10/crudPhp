<?php

include_once("models/connection.php");

function addGame($data) {
    global $connection;

    // Validaciones del lado del servidor
    if (empty($data['name'])) {
        return "El nombre del juego es obligatorio.";
    }

    if (empty($data['description'])) {
        return "La descripción es obligatoria.";
    }

    if ((int)$data['playtime'] <= 0) {
        return "La duración del juego debe ser mayor que 0.";
    }

    if ((int)$data['min_age'] <= 0) {
        return "La edad mínima debe ser mayor que 0.";
    }

    if ((int)$data['min_players'] <= 0 || (int)$data['max_players'] <= 0 || (int)$data['min_players'] > (int)$data['max_players']) {
        return "El número de jugadores debe ser válido.";
    }

    // Escapar y preparar los valores para la inserción en la base de datos
    $name = $connection->real_escape_string($data['name']);
    $description = $connection->real_escape_string($data['description']);
    $playtime = (int)$data['playtime'];
    $min_age = (int)$data['min_age'];
    $min_players = (int)$data['min_players'];
    $max_players = (int)$data['max_players'];
    $sleeves = isset($data['sleeves']) ? 1 : 0;
    $premiun = isset($data['premiun']) ? 1 : 0;
    $N_A = isset($data['N_A']) ? 1 : 0;

    // Consulta SQL para insertar el juego en la base de datos
    $sql = "INSERT INTO boardgames (name, playtime, min_age, min_players, max_players, description, sleeves, premiun, N_A) 
            VALUES ('$name', $playtime, $min_age, $min_players, $max_players, '$description', $sleeves, $premiun, $N_A)";

    if ($connection->query($sql)) {
        return "Juego añadido con éxito.";
    } else {
        return "Error al añadir el juego: " . $connection->error;
    }
}
?>
