<?php
include_once("models/connection.php");

function getBoardgames($page = 1, $results_per_page = 12, $initial = null) {
    global $connection;

    // Cálculo del offset
    $offset = ($page - 1) * $results_per_page;

    // Construir la base de la consulta
    $where_clause = "";
    $params = [];

    // Filtrar por inicial o números
    if ($initial) {
        if (preg_match('/^[A-Z]$/', $initial)) {
            // Filtro por letra inicial
            $where_clause = "WHERE name LIKE CONCAT(?, '%')";
            $params[] = $initial;
        } elseif ($initial === '0-9') {
            // Filtro por nombres que comienzan con un número
            $where_clause = "WHERE name REGEXP '^[0-9]'";
        }
    }

    // Consulta para contar el número total de registros
    $total_query = "SELECT COUNT(*) AS total FROM boardgames $where_clause";
    $stmt = $connection->prepare($total_query);
    if (!empty($params)) {
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $total_results = $result->fetch_object()->total;
    $total_pages = ceil($total_results / $results_per_page);

    // Consulta para obtener los resultados de la página actual
    $query = "SELECT * FROM boardgames $where_clause ORDER BY name ASC LIMIT $results_per_page OFFSET $offset";
    $stmt = $connection->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $boardgames = [];
    while ($row = $result->fetch_object()) {
        $boardgames[] = $row;
    }

    return [
        'boardgames' => $boardgames,
        'total_pages' => $total_pages
    ];
}
?>
