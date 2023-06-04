<div id="overlay">
    <div id="modal">
        <button id="closeModalBtn">&times;</button>
        <h4>Cambiar votación</h4>
        <div class="voteStars">
            <?php
            $starsFilled = round($_SESSION["productScoreByUser"]);
            for ($i = 0; $i < 5; $i++) {
                if ($i < $starsFilled) {
                    $class = "starSvgFull";
                } else {
                    $class = "starSvgEmpty";
                }
                $id = $i + 1;
                echo "
                        <svg xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'>
                            <polygon id='star-$id' class='starVoteIcon $class' points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'>
                            </polygon>
                        </svg>
                    ";
            }
            ?>
        </div>
        <form action="./controller/productInfoController.php" method="post">
            <input type="hidden" name="id_product" id="id_product" value="<?php echo $productId ?> ">
            <input type="hidden" name="changingScore" id="score" value="<?php echo $_SESSION["productScoreByUser"] ?>">
            <input type="hidden" name="id_user" value="<?php echo $_SESSION['user']->getId_user() ?>">
            <input class="button1" type="submit" value="Cambiar">
        </form>
    </div>
</div>

<script>
    // Añadir evento "click" a todas las estrellas
    var stars = document.querySelectorAll('.starVoteIcon');
    for (var i = 0; i < stars.length; i++) {

        stars[i].addEventListener('click', function(e) {
            // Obtener la cantidad de estrellas seleccionadas
            var score = e.target.id.split('-')[1];

            // Cambiar la clase de las estrellas anteriores y actuales
            for (var j = 1; j <= score; j++) {
                var star = document.getElementById('star-' + j);
                star.classList.remove('starSvgEmpty');
                star.classList.add('starSvgFull');
            }
            for (var k = parseInt(score) + 1; k <= 5; k++) {
                var star = document.getElementById('star-' + k);
                star.classList.remove('starSvgFull');
                star.classList.add('starSvgEmpty');
            }
            // Si la primera estrella está coloreada y se vuelve a clicar, se descolorean todas las estrellas
            if (this === document.querySelector('.starSvg:first-child') && !this.classList.contains('starSvgEmpty')) {
                var allStars = document.querySelectorAll('.starSvg');
                for (var j = 0; j < allStars.length; j++) {
                    allStars[j].classList.add('starSvgEmpty');
                }
                document.getElementById('stars').value = '';
            }
            // Actualizar el campo "input" con la cantidad de estrellas seleccionadas
            document.getElementById('score').value = score;
        });
    }
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