const url = "http://localhost"

const btnEditGame = document.getElementById("btnEditGame");
const btnAddGame = document.getElementById("btnAddGame");
const btnResetGame = document.getElementById("btnResetForm");
const titleForm = document.getElementById("titleForm");

document.addEventListener("DOMContentLoaded", function () {
    // Seleccionar todas las alertas con la clase `js-alert`
    const alerts = document.querySelectorAll(".js-alert");

    alerts.forEach(alert => {
        // Ocultar la alerta después de 5 segundos
        setTimeout(() => {
            alert.classList.remove("show"); // Quitar la clase `show` para activar el comportamiento `fade`
            alert.classList.add("hide"); // Opción: agregar una clase adicional si deseas personalizar el estilo

            // Eliminar completamente el elemento después de la transición
            setTimeout(() => alert.remove(), 500); // Esperar el tiempo de la animación (0.5s)
        }, 3000); // 5 segundos
    });
});

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

    const currentUrl = new URL(window.location.href);

    currentUrl.searchParams.set('id', id);
    window.history.pushState({}, '', currentUrl);



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
                // document.getElementById('gameForm').action = `controllers/updateGame.php?id=${id}`;
                
                debugger
                
                titleForm.innerText = "Editar Juego";

                if (btnEditGame.classList.contains("d-none")) {
                    btnEditGame.classList.remove("d-none");
                }

                if (btnResetGame.classList.contains("d-none")) {
                    btnResetGame.classList.remove("d-none");
                }

                if (!btnAddGame.classList.contains("d-none")){
                    btnAddGame.classList.add("d-none");
                }

                document.getElementById("btnEditGame").style.display = "block";
                document.getElementById("btnAddGame").style.display = "none";

            } else {
                alert('Error al cargar los datos del juego.');
            }
        });
}

function resetForm() {
    document.querySelector("form#gameForm").reset();

    titleForm.innerText = "Añadir Juego";

    if (!btnEditGame.classList.contains("d-none")) {
        btnEditGame.classList.add("d-none");
    }

    if (!btnResetGame.classList.contains("d-none")) {
        btnResetGame.classList.add("d-none");
    }

    if (btnAddGame.classList.contains("d-none")){
        btnAddGame.classList.remove("d-none");
    }
}