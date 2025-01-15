<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD PhP</title>

    <!-- CSS BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Icons Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>
    <?php

        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");    
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    ?>

    <div class="col">
        <h1 class="text-center">Menú Juegos de Mesa</h1>
    </div>
    <div class="container-fluid row">
        <!-- Formulario Alta y edicion -->
        <div class="col-3 p-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-center" id="titleForm">Añadir Juego</h5>
                </div>
                <div class="card-body">
                <?php


                    $isEditMode = isset($_GET['id']); // Si existe un parámetro id, estamos editando
                    $id = $isEditMode ? htmlspecialchars($_GET['id']) : ""; // Captura el id si está en modo edición

                    
                    $message = "";
                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnAddGame'])) {
                        include_once("controllers/GameAddController.php");
                        // Llamar a la función del controlador para añadir el juego
                        $message = addGame($_POST);
                    }
                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnEditGame'])) {
                        // Llamar a la función del controlador para añadir el juego
                        include_once("controllers/GameUpdateController.php");
                        $message = editGame($_POST);
                    }

                ?>
                    <form method="post" action="" id="gameForm">
                        <?php if ($message): ?>
                            <div class="alert alert-info alert-dismissible fade show js-alert" role="alert">
                                <?= htmlspecialchars($message) ?>
                            </div>
                        <?php endif; ?>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">id_Game</span>
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="id" readonly>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Nombre</span>
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="name">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Duración</span>
                            <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="playtime">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Mínimo Edad</span>
                            <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="min_age">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Mínimo Jugadores</span>
                            <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="min_players">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Máximo Jugadores</span>
                            <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="max_players">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Descripción</span>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
                        </div>

                        <div class="input-group input-group-sm mb-3">
                            <div class="form-check pe-3">
                                <input class="form-check-input" type="checkbox" value="" name="sleeves">
                                <label class="form-check-label" for="sleeves">
                                    Fundas
                                </label>
                            </div>
                            <div class="form-check pe-3">
                                <input class="form-check-input" type="checkbox" value="" name="premiun">
                                <label class="form-check-label" for="premiun">
                                    Premiun
                                </label>
                            </div>
                            <div class="form-check pe-3">
                                <input class="form-check-input" type="checkbox" value="" name="N_A">
                                <label class="form-check-label" for="N_A">
                                    No Aplica
                                </label>
                            </div>
                        </div>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="submit" class="btn btn-primary d-none" name="btnEditGame" id="btnEditGame">Edit Game</button>
                            <button type="submit" class="btn btn-warning d-none" name="btnResetForm" id="btnResetForm">Reset Form</button>
                            <button type="submit" class="btn btn-primary" name="btnAddGame" id="btnAddGame">Add Game</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php
            include_once("controllers/BoardgameController.php");

            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $initial = isset($_GET['letter']) ? $_GET['letter'] : null;
            
            $data = getBoardgames($page, 12, $initial);
            $boardgames = $data['boardgames'];
            $total_pages = $data['total_pages'];
        ?>
        <!-- Tabla get BBDD -->
        <div class="col-9 p-4">
<!-- Filtro por inicial -->
            <div class="mb-3 text-center">
                <div class="btn-group">.
                    <a href="?letter=0-9&page=1" class="btn btn-outline-primary <?= isset($_GET['letter']) && $_GET['letter'] === '0-9' ? 'active' : '' ?>">0-9</a>
                    <?php foreach (range('A', 'Z') as $letter): ?>
                        <a href="?letter=<?= $letter ?>" class="btn btn-outline-primary <?= isset($_GET['letter']) && $_GET['letter'] == $letter ? 'active' : '' ?>">
                            <?= $letter ?>
                        </a>
                    <?php endforeach; ?>
                    <a href="?page=1" class="btn btn-outline-primary <?= !isset($_GET['letter']) ? 'active' : '' ?>">Todos</a>
                </div>
            </div>

            <table class="table">
                <thead class="table-success">
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Duración</th>
                        <th scope="col">Edad</th>
                        <th scope="col">Jugadores</th>
                        <th scope="col">No Aplica</th>
                        <th scope="col">Fundas</th>
                        <th scope="col">Premium</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php foreach ($boardgames as $datos): ?>
                        <tr>
                            <th scope="row"><?= $datos->id ?></th>
                            <td><?= $datos->name ?></td>
                            <td><?= $datos->playtime ?></td>
                            <td><?= $datos->min_age ?></td>
                            <td><?= $datos->min_players == $datos->max_players ? $datos->min_players : "de $datos->min_players a $datos->max_players" ?></td>
                            <td class="<?= $datos->N_A ? 'text-success' : 'text-danger' ?>">
                                <i class="bi <?= $datos->N_A ? 'bi-check-lg' : 'bi-x-square' ?>"></i>
                            </td>
                            <td class="<?= $datos->sleeves ? 'text-success' : 'text-danger' ?>">
                                <i class="bi <?= $datos->sleeves ? 'bi-check-lg' : 'bi-x-square' ?>"></i>
                            </td>
                            <td class="<?= $datos->premiun ? 'text-success' : 'text-danger' ?>">
                                <i class="bi <?= $datos->premiun ? 'bi-check-lg' : 'bi-x-square' ?>"></i>
                            </td>
                            <td>
                                <a  onclick="editGame(<?= $datos->id ?>)" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                <a onclick="deleteGame(<?= $datos->id ?>)" class="btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Paginación -->
            <nav>
                <ul class="pagination justify-content-center">
                    <?php 
                    // Obtener la letra actual del filtro
                    $letter = isset($_GET['letter']) ? htmlspecialchars($_GET['letter']) : null;
                    ?>

                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page - 1 ?><?= $letter ? "&letter=$letter" : '' ?>">Anterior</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?><?= $letter ? "&letter=$letter" : '' ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page + 1 ?><?= $letter ? "&letter=$letter" : '' ?>">Siguiente</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>

        </div>
    </div>



    <!-- script BOOTSTRAP  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- JS Web -->
     <script src="js/app.js"></script>
</body>

</html>