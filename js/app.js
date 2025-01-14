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
                document.getElementsByName('id')[0].value = data.game.id;
                document.getElementsByName('name')[0].value = data.game.name;
                document.getElementsByName('playtime')[0].value = data.game.playtime;
                document.getElementsByName('min_age')[0].value = data.game.min_age;
                document.getElementsByName('min_players')[0].value = data.game.min_players;
                document.getElementsByName('max_players')[0].value = data.game.max_players;
                document.getElementsByName('description')[0].value = data.game.description;
                document.getElementsByName('sleeves')[0].checked = data.game.sleeves == 1;
                document.getElementsByName('premiun')[0].checked = data.game.premiun == 1;
                document.getElementsByName('N_A')[0].checked = data.game.N_A == 1;
                // Configurar el formulario para actualizar
                document.getElementById('gameForm').action = `controllers/updateGame.php?id=${id}`;
            } else {
                alert('Error al cargar los datos del juego.');
            }
        });
}