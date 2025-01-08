const url = "http://localhost"

function deleteGame(id) {
    if (confirm("¿Estás seguro de que deseas borrar este juego?")) {
        fetch(`controllers/deleteGame.php?id=${id}`, { method: 'POST' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Juego borrado con éxito.');
                    location.reload(); // Recargar la página
                } else {
                    alert('Error al borrar el juego.');
                }
            });
    }
}


function editGame(id) {
    // Hacer una solicitud AJAX para obtener los datos del juego
    fetch(`controllers/getGame.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Llenar el formulario con los datos del juego
                document.getElementById('name').value = data.game.name;
                document.getElementById('playtime').value = data.game.playtime;
                document.getElementById('min_age').value = data.game.min_age;
                document.getElementById('min_players').value = data.game.min_players;
                document.getElementById('max_players').value = data.game.max_players;
                document.getElementById('description').value = data.game.description;
                document.getElementById('sleeves').checked = data.game.sleeves == 1;
                document.getElementById('premiun').checked = data.game.premiun == 1;
                document.getElementById('N_A').checked = data.game.N_A == 1;
                // Configurar el formulario para actualizar
                document.getElementById('gameForm').action = `controllers/updateGame.php?id=${id}`;
            } else {
                alert('Error al cargar los datos del juego.');
            }
        });
}