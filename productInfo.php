<?php
include("service/AvatarService.php");
include("./model/UserModel.php");
include("./service/DBConnection.php");
include_once("model/ProductModel.php");
include("./dto/reviewDto.php");


session_start();
if (!isset($_SESSION['redireccion']) || empty($_SESSION['redireccion'])) {
    $idProduct = $_SESSION["currentProduct"]->getId_product();
    header("Location: ./controller/productInfoController.php?id=$idProduct");
    exit;
}
unset($_SESSION['redireccion']);
if (!isset($_SESSION["currentProduct"]) || !isset($_SESSION["currentAverageScore"]) || !isset($_SESSION["currentReviewList"])) {
    header("Location: ./index.php");
    exit;
}
if (isset($_SESSION["reviewErrorMessage"])) {
    $reviewErrorMessage = $_SESSION["reviewErrorMessage"];
    unset($_SESSION["reviewErrorMessage"]);
}
$currentProduct = $_SESSION["currentProduct"];
$productId = $currentProduct->getId_product();
$productName = $currentProduct->getName();
$productDescription = $currentProduct->getDescription();
$productShoppingLink = $currentProduct->getShopping_link();
$productMinPlayers = $currentProduct->getMin_playes();
$productMaxPlayers = $currentProduct->getMax_players();
$productLength = $currentProduct->getLength();
$productMinimumAge = $currentProduct->getMinimum_age();
$productType = $currentProduct->getType();
$productCategory = $currentProduct->getCategory();
$productPublisher = $currentProduct->getPublisher();
$productMediaList = $currentProduct->getMedia_list();
$currentAverageScore = $_SESSION["currentAverageScore"];
$currentReviewList = $_SESSION["currentReviewList"];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>4squares</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous" />
    <link rel="stylesheet" href="./style/productInfo.css" />
</head>

<body>
    <?php
    include("html/components/nav.php");
    //echo "<pre>";
    // print_r($productMediaList);
    //print_r($_SESSION);
    $infoContainerClass = $_SESSION["currentProduct"]->getHiden() ? 'info-container-hidden' : 'info-container';
    ?><div id="info-container" class="<?php echo $infoContainerClass ?>">
        <!-- ********************************** -->
        <!--             carrousel              -->
        <!-- ********************************** -->
        <div id="productId-2" class="carousel carousel-dark slide">
            <div class="carousel-inner">
                <?php
                for ($i = 0; $i < count($productMediaList); $i++) {
                    $urlMedia = $productMediaList[$i]['url'];
                    $typeMedia = $productMediaList[$i]['type'];

                    $active = "";
                    if ($i == 0) {
                        $active = "active";
                    }
                    if ($typeMedia == "image" || $typeMedia == "notFound") {
                        echo ('
                        <div class="carousel-item ' . $active . '">    
                            <img src="img/products/' . $urlMedia . '" class="d-block w-100" alt="..." />
                        </div>
                    ');
                    } elseif ($typeMedia == "video") {
                        echo ('
                        <div class="carousel-item ' . $active . '">
                            <div class="video">
                                <iframe src="' . $urlMedia . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </div>'
                        );
                    }
                }
                ?>
            </div>
            <div class="carousel-indicators">
                <?php
                for ($j = 0; $j < count($productMediaList); $j++) {

                    $active = "";
                    if ($j == 0) {
                        $active = 'class="active" aria-current="true"';
                    }
                    echo ('
                        <button type="button" data-bs-target="#productId-' . $productId . '" data-bs-slide-to="' . $j . '" ' . $active . ' aria-label="Slide ' . ($j + 1) . '"></button>
                    ');
                }

                ?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#productId-2" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hiden="true"></span>
                <!-- <span class="visually-hiden">Previous</span> -->
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productId-2" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hiden="true"></span>
                <!-- <span class="visually-hiden">Next</span> -->
            </button>
        </div>
        <!-- ********************************** -->
        <!--            datos producto          -->
        <!-- ********************************** -->
        <?php
        //Si el usuario no está registrado, añadimos boton de favorito que te manda a log, si no, boton funcional
        $favoriteIcon = "";
        if (!isset($_SESSION["user"])) {

            $favoriteIcon = "
                <svg id='favorite-icon' class='favoriteSvg' xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                    <path d='M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z'></path>
                </svg>
            ";
        } else {
            $favorteIconVisibility = "favoriteSvg";
            //$favorteIconVisibility = isset($_SESSION['isAFavoriteProduct']) && $_SESSION['isAFavoriteProduct'] ? 'favoriteSvg-on' : "favoriteSvg";
            if (isset($_SESSION['isAFavoriteProduct']) && $_SESSION['isAFavoriteProduct']) {
                $favorteIconVisibility = "favoriteSvg-on";
            }
            //meter aqui el boton de favoritos con clases distintas para que haga el fetch
            $favoriteIcon = "
                <svg id='favorite-icon-loged' class='$favorteIconVisibility' xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                    <path d='M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z'></path>
                </svg>
            ";
        }
        //Si usuario registrado tiene permisos de admin, añadimos el boton ocultar producto y borrar producto

        $hideProductIcon = "";
        $deleteProductIcon = "";
        $hideProductIconClass = $_SESSION["currentProduct"]->getHiden() ? 'hideSvg-off' : 'hideSvg';
        if (isset($_SESSION["user"]) && $_SESSION["user"]->getCredentials() == 1) {
            $hideProductIcon = "
                <svg id='hideProductIcon' class='$hideProductIconClass' xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                    <path d='M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z'></path>
                    <circle cx='12' cy='12' r='3'></circle>
                </svg>
            ";
            $deleteProductIcon = "
                <svg id='deleteProductIcon' class='deleteSvg' xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                    <polyline points='3 6 5 6 21 6'></polyline>
                    <path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path>
                    <line x1='10' y1='11' x2='10' y2='17'></line>
                    <line x1='14' y1='11' x2='14' y2='17'></line>
                </svg>
            ";
        }
        ?>
        <h1 id="product-name"><?php echo $productName ?></h1>
        <div id="score-vote-buy-container">
            <div id="score-container">
                <div id="product-score-number">
                    <p><?php echo $currentAverageScore ?></p>
                </div>
                <div id="stars">
                    <?php
                    for ($j = 0; $j < 5; $j++) {
                        $class = "starSvgFilled";
                        if (round($currentAverageScore) < $j + 1) {
                            $class = "starSvgEmpty";
                        }
                        echo ("
                                <svg class='$class' xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'>
                                    <polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'></polygon>
                                </svg>
                            ");
                    }
                    ?>
                </div>
            </div>
            <div id="vote-buy-buttons">
                <?php echo $hideProductIcon . $deleteProductIcon . $favoriteIcon ?>
                <button id="vote-button"><?php echo isset($_SESSION['productScoreByUser']) && $_SESSION['productScoreByUser'] ? 'Cambiar voto' : "Votar"; ?></button>
                <a id="buy-button" href="<?php echo $productShoppingLink ?>">
                    <img class="button-amazon-hover" src="img/buttons/button-amazon-hover.png" alt="" />
                    <img class="button-amazon" src="img/buttons/button-amazon.png" alt="" />
                </a>
            </div>
        </div>

        <div id="players-length-age-container">
            <div id="players">
                <img id="players-icon" src="./img/icons/players.svg" alt="" />
                <p id="players-range"><?php echo ($productMinPlayers . " - " . $productMaxPlayers) ?></p>
            </div>
            <div id="length">
                <img id="length-icon" src="./img/icons/length.svg" alt="" />
                <p id="length-range"><?php echo ($productLength . " min") ?></p>
            </div>
            <div id="age">
                <img id="age-icon" src="./img/icons/age.svg" alt="" />
                <p id="age-range"><?php echo ("+" . $productMinimumAge) ?></p>
            </div>
        </div>
        <p id="product-description">
            <?php echo ($productDescription) ?>
        </p>
        <!-- ********************************** -->
        <!--    tabla con datos del producto    -->
        <!-- ********************************** -->

        <?php
        //echo $_SESSION['isAFavoriteProduct'];
        // echo "<pre>";
        // print_r($_SESSION);
        ?>
        <table>
            <tr>
                <td id="min-players-row">
                    <h3>Mínimo de jugadores:</h3>
                    <p><?php echo ($productMinPlayers) ?></p>
                </td>
                <td id="max-h3layers-row">
                    <h3>Máximo de jugadores:</h3>
                    <p><?php echo ($productMaxPlayers) ?></p>
                </td>
            </tr>
            <tr>
                <td id="length-row">
                    <h3>Duración aproximada:</h3>
                    <p><?php echo ($productLength . " min") ?></p>
                </td>
                <td id="min-age-row">
                    <h3>Edad mínima:</h3>
                    <p><?php echo ("+" . $productMinimumAge) ?></p>
                </td>
            </tr>
            <tr>
                <td id="tyh3e-row">
                    <h3>Tipo de juego:</h3>
                    <p><?php echo ($productType) ?></p>
                </td>
                <td id="category-row">
                    <h3>Categoría:</h3>
                    <p><?php echo ($productCategory) ?></p>
                </td>
            </tr>
            <tr>
                <td id="h3ublisher-row">
                    <h3>Editorial:</h3>
                    <p><?php echo ($productPublisher) ?></p>
                </td>
            </tr>
        </table>
        <a name="error"></a>
    </div>
    <!-- ********************************** -->
    <!--        seccion de comentario       -->
    <!-- ********************************** -->
    <div id="social-container">
        <?php
        //primera parte de la seccion de comentarios, la caja para escribir un comentario...
        if (!empty($currentReviewList)) {
            echo "<h4>Deja tu comentario.</h4>";
        } else {
            echo "<h4>Sé el primero en dejar un comentario.</h4>";
        }
        if (isset($reviewErrorMessage)) {
            echo "<p style='color:red;'>$reviewErrorMessage</p>";
        }
        if (isset($_SESSION['user'])) {
            include("./html/components/reviewForm.php");
        } else {
            echo ("
                <div id='logInToReview'>
                    <h4>Haz Log in para poder comentar</h4>
                    <a class='button1' href='controller/loginController.php'>Log in</a> 
                </div>
            ");
        }
        ?>

        <?php
        //comentarios de todos los usuarios
        if (!empty($currentReviewList)) {
            for ($i = count($currentReviewList) - 1; $i >= 0; $i--) {

                $muteIcon = "";
                $deleteUserIcon = "";
                $idUser = $currentReviewList[$i]->getIdUser();
                $mutedUserIconClass = "muted-user-icon-off";
                //si el creador del comentario está muteado
                if ($currentReviewList[$i]->getUserMuted()) {
                    $mutedUserIconClass = "muted-user-icon";
                }


                $deleteIcon = "";
                $idReview = $currentReviewList[$i]->getIdReview();
                //Si el comentario es del usuario que está registrado o el usuario registrado tiene permisos de admin, añadimos el boton de borrar
                if ((isset($_SESSION["user"]) && $currentReviewList[$i]->getIdUser() == $_SESSION["user"]->getId_user()) || (isset($_SESSION["user"]) && $_SESSION["user"]->getCredentials() == 1)) {
                    $deleteIcon = "
                    <svg id='deleteIconReviewId-$idReview' class='deleteSvg deleteIcon' xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                        <polyline class='deleteIcon' points='3 6 5 6 21 6'></polyline>
                        <path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path>
                        <line x1='10' y1='11' x2='10' y2='17'></line>
                        <line x1='14' y1='11' x2='14' y2='17'></line>
                    </svg>
                    ";
                }

                $hideIcon = "";
                $hiddenReview = "";
                //si el comentario esta oculto añadimos la clase que lo hace transparente
                if ($currentReviewList[$i]->gethidden()) {
                    $hideSvgClass = "hideSvg-off";
                    $hiddenReview = "hidden-review";
                } else {
                    $hideSvgClass = "hideSvg";
                }
                //si el creador del comentario esta muteado y el usuario registrado es admin, ponemos el nombre del creador del comentario en rojo
                $userNameMutedClass = "";
                $noticeUserIsMuted

                    = "";
                if ($currentReviewList[$i]->getUserMuted() && isset($_SESSION["user"]) && $_SESSION["user"]->getCredentials() == 1) {
                    $userNameMutedClass = "userNameMutedClass";
                    $noticeUserIsMuted = "Usuario muteado.";
                }

                //aunque el comentario esté oculto, no se mostrara transaparente para el usuario que ha hecho el comentario a no ser que sea el admin
                if ($currentReviewList[$i]->gethidden() && isset($_SESSION["user"]) &&  $_SESSION["user"]->getCredentials() == 0 && $currentReviewList[$i]->getIdUser() == $_SESSION["user"]->getId_user()) {
                    $hiddenReview = "";
                }

                //Si usuario registrado tiene permisos de admin, añadimos el boton ocultar comentario, mutear usuario y eliminar usuario
                if (isset($_SESSION["user"]) && $_SESSION["user"]->getCredentials() == 1) {
                    $hideIcon = "
                        <svg id='hideIconReviewId-$idReview' class='hideIcon $hideSvgClass' xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                            <path d='M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z'></path>
                            <circle cx='12' cy='12' r='3'></circle>
                        </svg>
                    ";
                    $muteIcon = "
                        <svg id='muteIconUserId-$idUser' class='muteUserIcon $mutedUserIconClass' viewBox='0 0 20 20'>
                            <path d='M18.084,11.639c0.168,0.169,0.168,0.442,0,0.611c-0.084,0.084-0.195,0.127-0.306,0.127c-0.111,0-0.221-0.043-0.306-0.127l-1.639-1.639l-1.639,1.639c-0.084,0.084-0.195,0.127-0.306,0.127c-0.111,0-0.222-0.043-0.307-0.127c-0.168-0.169-0.168-0.442,0-0.611L15.223,10l-1.64-1.639c-0.168-0.168-0.168-0.442,0-0.61c0.17-0.169,0.442-0.169,0.612,0l1.639,1.639l1.639-1.639c0.169-0.169,0.442-0.169,0.611,0c0.168,0.168,0.168,0.442,0,0.61L16.445,10L18.084,11.639z M12.161,2.654v14.691c0,0.175-0.105,0.333-0.267,0.4c-0.054,0.021-0.109,0.032-0.166,0.032c-0.111,0-0.223-0.043-0.305-0.127l-3.979-3.979H2.222c-0.237,0-0.432-0.194-0.432-0.432V6.759c0-0.237,0.195-0.432,0.432-0.432h5.222l3.979-3.978c0.123-0.125,0.309-0.163,0.471-0.095C12.056,2.322,12.161,2.479,12.161,2.654 M7.192,7.192H2.654v5.617h4.538V7.192z M11.296,3.698l-3.24,3.241v6.123l3.24,3.24V3.698z'></path>
                        </svg>
                    ";
                    $deleteUserIcon = "
                        <svg id='deleteUserIconUserId-$idUser' class='deleteUserIcon delete-user-icon' viewBox='0 0 20 20'>
                            <path d='M10.185,1.417c-4.741,0-8.583,3.842-8.583,8.583c0,4.74,3.842,8.582,8.583,8.582S18.768,14.74,18.768,10C18.768,5.259,14.926,1.417,10.185,1.417 M10.185,17.68c-4.235,0-7.679-3.445-7.679-7.68c0-4.235,3.444-7.679,7.679-7.679S17.864,5.765,17.864,10C17.864,14.234,14.42,17.68,10.185,17.68 M10.824,10l2.842-2.844c0.178-0.176,0.178-0.46,0-0.637c-0.177-0.178-0.461-0.178-0.637,0l-2.844,2.841L7.341,6.52c-0.176-0.178-0.46-0.178-0.637,0c-0.178,0.176-0.178,0.461,0,0.637L9.546,10l-2.841,2.844c-0.178,0.176-0.178,0.461,0,0.637c0.178,0.178,0.459,0.178,0.637,0l2.844-2.841l2.844,2.841c0.178,0.178,0.459,0.178,0.637,0c0.178-0.176,0.178-0.461,0-0.637L10.824,10z'></path>
                        </svg>
                    ";
                }
                //se muestra el comentario si no esta oculto o si esta oculto pero el usuario es el admin, o si está oculto pero el usuario es el creador del comentario, y ademas, se mostrara si el creador del comentario no esta muteado o si esta muteado pero el usuario registrado es el propio creador del comentario o un admin
                if ((!$currentReviewList[$i]->gethidden() || (isset($_SESSION["user"]) && $_SESSION["user"]->getCredentials() == 1) || (isset($_SESSION["user"]) && $currentReviewList[$i]->getIdUser() == $_SESSION["user"]->getId_user())) && (!$currentReviewList[$i]->getUserMuted() || ($currentReviewList[$i]->getUserMuted() && (isset($_SESSION["user"]) && ($_SESSION["user"]->getCredentials() == 1 || ($currentReviewList[$i]->getIdUser() == $_SESSION["user"]->getId_user())))))) {
                    echo ("
                    <div class='user-review $hiddenReview'>
                        <hr />
                        <div class='user-review-data'>
                            <div class='userNameAndNoticeUserIsMuted'>
                                <p class='user-name $userNameMutedClass'>" . $currentReviewList[$i]->getNickname() . "</p>
                                <p class='noticeUserIsMuted'>" . $noticeUserIsMuted . "</p>
                            </div>
                            <div class='dateAndDelete'>
                            <p class='review-date'>" . $currentReviewList[$i]->getDate() . "</p>
                            $deleteIcon
                            $hideIcon
                            
                            </div>
                        </div>
                        <div class='photo-and-review-container'>
                            <div class='img-box'>
                                <img src='./img/avatars/" . $currentReviewList[$i]->getAvatar() . "' alt='' />
                                <div class='mute-and-delete-icons-container'  >
                                    $muteIcon
                                    $deleteUserIcon
                                </div>
                            </div>
                            <p>
                            " . $currentReviewList[$i]->getReview() . "
                            </p>
                        </div>
                    </div>
                ");
                }
            }
        }
        ?>
    </div>
    <?php
    //Pop up que sale al darle al boton de votar
    if (isset($_SESSION['user'])) {
        if (isset($_SESSION['productScoreByUser']) && $_SESSION['productScoreByUser']) {
            include("./html/components/productInfoVoteLogedAndVoted.php");
        } else {
            include("./html/components/productInfoVoteLoged.php");
        }
    } else {
        include("./html/components/productInfoVoteNotLoged.php");
        include("./html/components/favoriteButtonNotLoged.php");
    }
    ?>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script>
    //funcion para borrar comentarior
    var deleteIcons = document.querySelectorAll('.deleteIcon');

    for (var i = 0; i < deleteIcons.length; i++) {
        deleteIcons[i].addEventListener('click', function() {
            // Obtener el ID del comentario a borrar
            var reviewId = this.id.split('-')[1];
            if (confirm("¿Estás seguro de que quieres eliminar este comentario?")) {
                fetch(`http://localhost/tfg/4squares/controller/productInfoController.php?deleteReview=${reviewId}`, {
                        method: 'GET'
                    })
                    .then(response => {
                        if (response.ok) {
                            const reviewContainer = document.querySelector(`#deleteIconReviewId-${reviewId}`).closest('.user-review');
                            reviewContainer.remove();
                        } else {
                            alert('No se pudo eliminar el comentario.');
                        }
                    })
                    .catch(error => {
                        alert('No se pudo eliminar el comentario.');
                    });
            }
        });
    }

    //funcion para ocultar comentarior
    var hideIcons = document.querySelectorAll('.hideIcon');

    for (var i = 0; i < hideIcons.length; i++) {

        hideIcons[i].addEventListener('click', function() {
            //Obtener el ID del comentario a borrar
            var reviewId = this.id.split('-')[1];

            var value;
            this.classList.contains("hideSvg-off") ? value = 0 : value = 1;
            fetch(`http://localhost/tfg/4squares/controller/productInfoController.php?hideReview=${reviewId}&value=${value}`, {
                    method: 'GET'
                })
                .then(response => {
                    if (response.ok) {
                        const reviewContainer = document.querySelector(`#deleteIconReviewId-${reviewId}`).closest('.user-review');
                        //cambia la clase del icono al pincharlo y la transparencia del comentario
                        if (this.classList.contains("hideSvg") && !this.classList.contains("hideSvg-off")) {
                            reviewContainer.classList.add("hidden-review")
                            this.classList.add("hideSvg-off");
                            this.classList.remove("hideSvg");
                        } else if (!this.classList.contains("hideSvg") && this.classList.contains("hideSvg-off")) {
                            this.classList.add("hideSvg");
                            this.classList.remove("hideSvg-off");
                            reviewContainer.classList.remove("hidden-review")
                        }
                    } else {
                        alert('No se pudo ocultar el comentario.');
                    }
                })
                .catch(error => {
                    alert('No se pudo ocultar el comentario.');
                });
        });
    }
    //funcion para mutear usuario
    var muteUserIcons = document.querySelectorAll('.muteUserIcon');

    for (var i = 0; i < muteUserIcons.length; i++) {

        muteUserIcons[i].addEventListener('click', function() {
            //Obtener el ID del usuario a mutear
            var idUser = this.id.split('-')[1];

            var value;
            this.classList.contains("muted-user-icon-off") ? value = 1 : value = 0;

            fetch(`http://localhost/tfg/4squares/controller/userController.php?muteUser=true&id=${idUser}&value=${value}`, {
                    method: 'GET'
                })
                .then(response => {
                    if (response.ok) {
                        // const userNameAndNoticeUserIsMuted = this;
                        //const userNameAndNoticeUserIsMuted = this.parentNode.parentNode.parentNode.parentNode.querySelector('.user-review-data').querySelector('.userNameAndNoticeUserIsMuted');

                        // //cambia la clase del icono al pincharlo y la transparencia del comentario
                        if (this.classList.contains("muted-user-icon")) {
                            //alert('El usuario ha sido desmuteado.');
                            const elements = document.querySelectorAll(`div.user-review [id^='muteIconUserId-'][id$='-${idUser}']`);
                            for (let j = 0; j < elements.length; j++) {
                                const userNameAndNoticeUserIsMuted = elements[j].parentNode.parentNode.parentNode.parentNode.querySelector('.user-review-data').querySelector('.userNameAndNoticeUserIsMuted');
                                elements[j].classList.remove("muted-user-icon");
                                elements[j].classList.add("muted-user-icon-off");
                                userNameAndNoticeUserIsMuted.querySelector('.noticeUserIsMuted').innerHTML = "";
                                userNameAndNoticeUserIsMuted.querySelector('.user-name').classList.remove('userNameMutedClass');
                            }
                        } else if (this.classList.contains("muted-user-icon-off")) {
                            // alert('El usuario ha sido muteado.');
                            const elements = document.querySelectorAll(`div.user-review [id^='muteIconUserId-'][id$='-${idUser}']`);
                            for (let j = 0; j < elements.length; j++) {
                                const userNameAndNoticeUserIsMuted = elements[j].parentNode.parentNode.parentNode.parentNode.querySelector('.user-review-data').querySelector('.userNameAndNoticeUserIsMuted');
                                elements[j].classList.remove("muted-user-icon-off");
                                elements[j].classList.add("muted-user-icon");
                                userNameAndNoticeUserIsMuted.querySelector('.noticeUserIsMuted').innerHTML = "Usuario muteado.";
                                userNameAndNoticeUserIsMuted.querySelector('.user-name').classList.add('userNameMutedClass');
                            }

                        }
                    } else {
                        alert('No se pudo mutear al usuario.');
                    }
                })
                .catch(error => {
                    alert('No se pudo mutear al usuario.');
                });
        });
    }

    //funcion para borrar usuario
    var deleteUserIcon = document.querySelectorAll('.deleteUserIcon');

    for (var i = 0; i < deleteUserIcon.length; i++) {
        deleteUserIcon[i].addEventListener('click', function() {
            // Obtener el ID del usuario a borrar
            var userId = this.id.split('-')[1];
            if (confirm("¿Estás seguro de que quieres eliminar este usuario? Esta acción eliminará definitivamente al usuario y todos sus comentarios.")) {
                fetch(`http://localhost/tfg/4squares/controller/userController.php?deleteUser=true&userId=${userId}`, {
                        method: 'GET'
                    })
                    .then(response => {
                        if (response.ok) {
                            //Se todos los comentarios del usuario de esta pagina y se borran
                            alert('El usuario ha sido eliminado.');
                            const elements = document.querySelectorAll(`div.user-review [id^='deleteUserIconUserId-'][id$='-${userId}']`);
                            for (let j = 0; j < elements.length; j++) {
                                const userReview = elements[j].parentNode.parentNode.parentNode.parentNode;
                                userReview.remove();
                            }
                        } else {
                            alert('No se pudo eliminar el usuario.');
                        }
                    })
                    .catch(error => {
                        alert('No se pudo eliminar el usuario.');
                    });
            }
        });
    }

    //funcion para agregar o eliminar a favorito
    var favoriteIcon = document.getElementById('favorite-icon-loged');

    favoriteIcon.addEventListener('click', function() {

        var productId = <?php echo $_SESSION["currentProduct"]->getId_product() ?>;
        var userId = <?php echo $_SESSION["user"]->getId_user() ?>;
        // alert("productId: " + productId + " - userId: " + userId);
        fetch(`http://localhost/tfg/4squares/controller/favoriteController.php?switchFavorite=true&productId=${productId}&userId=${userId}`, {
                method: 'GET'
            })
            .then(response => {
                if (response.ok) {
                    if (this.classList.contains("favoriteSvg-on")) {
                        this.classList.add("favoriteSvg");
                        this.classList.remove("favoriteSvg-on");
                    } else {
                        this.classList.remove("favoriteSvg");
                        this.classList.add("favoriteSvg-on");
                    }
                } else {
                    alert('No se pudo pudo modificar favoritos.');
                }
            })
            .catch(error => {
                alert('No se pudo pudo modificar favoritos.');
            });
    });

    //funcion para ocultar o publicar producto
    var hideProductIcon = document.getElementById('hideProductIcon');
    var infoContainer = document.getElementById('info-container');

    hideProductIcon.addEventListener('click', function() {

        var productId = <?php echo $_SESSION["currentProduct"]->getId_product() ?>;
        var value = <?php echo $_SESSION["currentProduct"]->getHiden() ?>;
        fetch(`http://localhost/tfg/4squares/controller/productController.php?switchProductHideState=true&productId=${productId}&value=${value}`, {
                method: 'GET'
            })
            .then(response => {
                if (response.ok) {
                    //hago visible el producto
                    if (this.classList.contains("hideSvg-off")) {
                        this.classList.add("hideSvg");
                        this.classList.remove("hideSvg-off");
                        infoContainer.classList.add("info-container");
                        infoContainer.classList.remove("info-container-hidden");
                    } //oculto el producto
                    else {
                        this.classList.remove("hideSvg");
                        this.classList.add("hideSvg-off");
                        infoContainer.classList.remove("info-container");
                        infoContainer.classList.add("info-container-hidden");
                    }
                } else {
                    alert('No se pudo pudo modificar favoritos.');
                }
            })
            .catch(error => {
                alert('No se pudo pudo modificar favoritos.');
            });
    });

    //funcion para borrar un producto
    var deleteProductIcon = document.getElementById('deleteProductIcon');

    deleteProductIcon.addEventListener('click', function() {
        var productId = <?php echo $_SESSION["currentProduct"]->getId_product() ?>;

        if (confirm("¿Estás seguro de que quieres eliminar este producto? Esta acción eliminará definitivamente el producto.")) {
            fetch(`http://localhost/tfg/4squares/controller/productController.php?deleteProduct=true&productId=${productId}`, {
                    method: 'GET'
                })
                .then(response => {
                    if (response.ok) {
                        //Si se borra el producto
                        alert('El producto ha sido eliminado.');
                        location.href = 'http://localhost/tfg/4squares/index.php';
                    } else {
                        alert('No se pudo eliminar el producto.');
                    }
                })
                .catch(error => {
                    alert('No se pudo eliminar el producto.');
                });
        }
    });
</script>

</html>