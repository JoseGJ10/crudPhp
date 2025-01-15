<?php



include_once("models/connection.php");

function getBoardgames($page = 1, $results_per_page = 12, $initial = null) {
    global $connection;

    // Sanitizar los valores de entrada
    $page = max(1, intval($page));
    $results_per_page = max(1, intval($results_per_page));
    $offset = ($page - 1) * $results_per_page;

    // Inicialización
    $where_clause = "";
    $params = [];
    $param_types = "";

    // Construir WHERE en función de $initial
    if ($initial) {
        if (preg_match('/^[A-Z]$/', $initial)) {
            $where_clause = "WHERE name LIKE CONCAT(?, '%')";
            $params[] = $initial;
            $param_types .= "s";
        } elseif ($initial === '0-9') {
            $where_clause = "WHERE name REGEXP '^[0-9]'"; // No requiere parámetros
        }
    }

    // Consulta para contar resultados totales
    $total_query = "SELECT COUNT(*) AS total FROM boardgames $where_clause";
    $stmt = $connection->prepare($total_query);
    if (!$stmt) {
        return ['error' => 'Error al preparar la consulta para el total de resultados.'];
    }

    // Asignar parámetros a la consulta de conteo
    if (!empty($params)) {
        $stmt->bind_param($param_types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $total_results = $result->fetch_object()->total ?? 0;
    $total_pages = ceil($total_results / $results_per_page);

    // Consulta para los resultados de la página actual
    $query = "SELECT * FROM boardgames $where_clause ORDER BY name ASC LIMIT ? OFFSET ?";
    $stmt = $connection->prepare($query);
    if (!$stmt) {
        return ['error' => 'Error al preparar la consulta para los resultados paginados.'];
    }

    // Agregar parámetros para paginación
    if (!empty($params)) {
        $param_types .= "ii"; // Agregar los tipos de LIMIT y OFFSET
        $params[] = $results_per_page;
        $params[] = $offset;
        $stmt->bind_param($param_types, ...$params);
    } else {
        $stmt->bind_param("ii", $results_per_page, $offset);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $boardgames = [];
    while ($row = $result->fetch_object()) {
        $boardgames[] = $row;
    }

    return [
        'boardgames' => $boardgames,
        'total_pages' => $total_pages,
        'total_results' => $total_results,
    ];
}
