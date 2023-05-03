<div id="overlay">
    <div id="modal">
        <button id="closeModalBtn">&times;</button>
        <h4>Haz Log in para votar.</h4>
        <a class="button1" href="controller/loginController.php">Log in</a>
    </div>
</div>

<script>
    //para el menu de votación
    // Obtenemos los elementos del DOM
    var voteButton = document.getElementById("vote-button");
    var closeModalBtn = document.getElementById("closeModalBtn");
    var overlay = document.getElementById("overlay");

    // Añadimos el evento 'click' al botón de abrir la capa
    voteButton.addEventListener("click", function() {
        overlay.style.display = "block";
    });

    // Añadimos el evento 'click' al botón de cerrar
    closeModalBtn.addEventListener("click", function() {
        overlay.style.display = "none";
    });
</script>