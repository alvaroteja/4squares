<!-- <button id="vote-button">Abrir capa</button> -->
<div id="overlay">
    <div id="modal">
        <button id="closeModalBtn">&times;</button>
        <h4>¿Qué nota se merece?</h4>
        <div class="voteStars">
            <svg xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'>
                <polygon id="star-1" class='starVoteIcon starSvgFull' points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'>
                </polygon>
            </svg>
            <svg xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'>
                <polygon id="star-2" class='starVoteIcon starSvgFull' points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'>
                </polygon>
            </svg>
            <svg xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'>
                <polygon id="star-3" class='starVoteIcon starSvgFull' points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'>
                </polygon>
            </svg>
            <svg xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'>
                <polygon id="star-4" class='starVoteIcon starSvgFull' points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'>
                </polygon>
            </svg>
            <svg xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'>
                <polygon id="star-5" class='starVoteIcon starSvgFull' points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'>
                </polygon>
            </svg>
        </div>
        <form action="/submit-rating" method="post">
            <input type="hidden" name="rating" id="rating" value="5">
            <input class="button1" type="submit" value="Enviar">
        </form>
    </div>
</div>

<script>
    // Añadir evento "click" a todas las estrellas
    var stars = document.querySelectorAll('.starVoteIcon');
    for (var i = 0; i < stars.length; i++) {

        stars[i].addEventListener('click', function(e) {
            // Obtener la cantidad de estrellas seleccionadas
            var rating = e.target.id.split('-')[1];

            // Cambiar la clase de las estrellas anteriores y actuales
            for (var j = 1; j <= rating; j++) {
                var star = document.getElementById('star-' + j);
                star.classList.remove('starSvgEmpty');
                star.classList.add('starSvgFull');
            }
            for (var k = parseInt(rating) + 1; k <= 5; k++) {
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
            document.getElementById('rating').value = rating;
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