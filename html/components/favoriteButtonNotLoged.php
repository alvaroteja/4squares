<div id='overlayFavoriteIcon'>
    <div id='modalFavoriteIcon'>
        <button id='closeModalBtnFavoriteIcon'>&times;</button>
        <h4>Haz Log in para porder añadir a favoritos.</h4>
        <a class='button1' href='controller/loginController.php'>Log in</a>
    </div>
</div>

<script>
    var favoriteIcon = document.getElementById("favorite-icon");
    var closeModalBtnFavoriteIcon = document.getElementById("closeModalBtnFavoriteIcon");
    var overlayFavoriteIcon = document.getElementById("overlayFavoriteIcon");

    // Añadimos el evento 'click' al botón de abrir la capa
    favoriteIcon.addEventListener("click", function() {
        overlayFavoriteIcon.style.display = "block";
    });
    // Añadimos el evento 'click' al botón de cerrar
    closeModalBtnFavoriteIcon.addEventListener("click", function() {
        overlayFavoriteIcon.style.display = "none";
    });
</script>