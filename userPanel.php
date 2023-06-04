<?php
include("service/AvatarService.php");
include("./model/UserModel.php");
include("./service/DBConnection.php");
include("./dto/UserPanelFavoriteDto.php");
include("./model/AvatarModel.php");


session_start();

if (!isset($_SESSION['userPanelControllerRedireccion']) || empty($_SESSION['userPanelControllerRedireccion'])) {
    header("Location: ./controller/userPanelController.php");
    exit;
}
unset($_SESSION['userPanelControllerRedireccion']);

$firstName = $_SESSION["user"]->getFirst_name();
$surename = $_SESSION["user"]->getSurename();
$nickname = $_SESSION["user"]->getNickname();
$email = $_SESSION["user"]->getEmail();
$userId = $_SESSION["user"]->getId_user();
$avatarsList = $_SESSION["avatarsList"];

$userPanelFavoriteList = $_SESSION["userPanelFavoriteList"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>4squares -panel de usuario</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tangerine&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous" />
    <link rel="stylesheet" href="style/userPanel.css" />
    <link rel="icon" href="./img/icons/favicon.ico">
</head>

<body>
    <?php
    include("html/components/nav.php");
    ?>
    <div id="overlay" class="overlay">
        <div class="avatar-selector">
            <button id="closeModalBtn">&times;</button>
            <?php for ($i = 0; $i < count($avatarsList); $i++) {
                $id = $avatarsList[$i]->getId();
                $url = $avatarsList[$i]->getUrl();
                echo "
                <img id='avatar-$id' src='./img/avatars/$url' alt='Avatar $id' class='avatar-thumbnail' data-src='./img/avatars/$url' />
                ";
            } ?>
        </div>
    </div>
    <div id="userDataContainer" class="container">
        <div id="imgContainer">
            <img id="avatar-img" src="./img/avatars/<?php echo $_SESSION["user"]->getId_avatar() ?>" alt="Avatar actual" class="avatar-img" />
            <button id="avatar-btn">Cambiar avatar</button>
        </div>
        <div id="dataContainer">
            <div class="singleDate">
                <h3 class="singleDateTitle">Nombre de usuario</h3>
                <p class="SingleDateDate"><?php echo $nickname  ?></p>
            </div>
            <div class="singleDate">
                <h3 class="singleDateTitle">Nombre</h3>
                <p class="SingleDateDate"><?php echo $firstName ?></p>
            </div>
            <div class="singleDate">
                <h3 class="singleDateTitle">Apellido</h3>
                <p class="SingleDateDate"><?php echo $surename ?></p>
            </div>
            <div class="singleDate">
                <h3 class="singleDateTitle">Email</h3>
                <p class="SingleDateDate"><?php echo $email ?></p>
            </div>
        </div>
        <?php
        ?>
    </div>
    <div id="favoriteContainer" class="container">
        <h2>Lista de favoritos</h2>
        <?php
        if (!$userPanelFavoriteList) {
            echo "
                <div id='emptyList'>
                    <p >Tu <em>lista de favoritos</em> está vacía, date una vuelta por la web en busca de <em>los mejores juegos</em>.</p>
                    <a href='./index.php'>
                        <svg class='svg-icon' viewBox='0 0 20 20' stroke-width='1' stroke-linecap='round' stroke-linejoin='round'>
                            <path d='M14.613,10c0,0.23-0.188,0.419-0.419,0.419H10.42v3.774c0,0.23-0.189,0.42-0.42,0.42s-0.419-0.189-0.419-0.42v-3.774H5.806c-0.23,0-0.419-0.189-0.419-0.419s0.189-0.419,0.419-0.419h3.775V5.806c0-0.23,0.189-0.419,0.419-0.419s0.42,0.189,0.42,0.419v3.775h3.774C14.425,9.581,14.613,9.77,14.613,10 M17.969,10c0,4.401-3.567,7.969-7.969,7.969c-4.402,0-7.969-3.567-7.969-7.969c0-4.402,3.567-7.969,7.969-7.969C14.401,2.031,17.969,5.598,17.969,10 M17.13,10c0-3.932-3.198-7.13-7.13-7.13S2.87,6.068,2.87,10c0,3.933,3.198,7.13,7.13,7.13S17.13,13.933,17.13,10'></path>
                        </svg>
                    </a>
                </div>
                ";
        } else {
            echo "
                    <div id='favoriteProductsContainer'>
                ";
            for ($i = 0; $i < count($userPanelFavoriteList); $i++) {
                $aveScor = $userPanelFavoriteList[$i]->getAverageScore();
                $prodName = $userPanelFavoriteList[$i]->getName();
                $prodImg = $userPanelFavoriteList[$i]->getImg();
                include("./html/components/userPanelFavoriteProduct.php");
            }
            echo "
                        <div class='favoriteProduct favoriteProductAdd'>
                            <p>Anadir más</p>
                            <a href='./index.php'>
                            <svg class='addMoreFavorites' viewBox='0 0 20 20' stroke-width='1' stroke-linecap='round' stroke-linejoin='round'>
                                <path d='M14.613,10c0,0.23-0.188,0.419-0.419,0.419H10.42v3.774c0,0.23-0.189,0.42-0.42,0.42s-0.419-0.189-0.419-0.42v-3.774H5.806c-0.23,0-0.419-0.189-0.419-0.419s0.189-0.419,0.419-0.419h3.775V5.806c0-0.23,0.189-0.419,0.419-0.419s0.42,0.189,0.42,0.419v3.775h3.774C14.425,9.581,14.613,9.77,14.613,10 M17.969,10c0,4.401-3.567,7.969-7.969,7.969c-4.402,0-7.969-3.567-7.969-7.969c0-4.402,3.567-7.969,7.969-7.969C14.401,2.031,17.969,5.598,17.969,10 M17.13,10c0-3.932-3.198-7.13-7.13-7.13S2.87,6.068,2.87,10c0,3.933,3.198,7.13,7.13,7.13S17.13,13.933,17.13,10'></path>
                            </svg>
                            </a>
                        </div>
                    </div>
                ";
        }
        ?>

    </div>
</body>
<script>
    // Obtenemos los elementos del DOM
    var voteButton = document.getElementById("avatar-btn");
    var closeModalBtn = document.getElementById("closeModalBtn");
    var overlay = document.getElementById("overlay");
    var avatarImg = document.getElementById("avatar-img");
    var navImg = document.getElementById("navUserImg");
    const avatarSelectorsImgs = document.querySelectorAll(".avatar-thumbnail");

    // Añadimos el evento 'click' al botón de abrir la capa
    voteButton.addEventListener("click", function() {
        overlay.classList.add("active");
    });

    // Añadimos el evento 'click' al botón de cerrar
    closeModalBtn.addEventListener("click", function() {
        overlay.classList.remove("active");
    });

    // Añadimos el evento 'click' a todas las miniaturas de avatar
    for (let i = 0; i < avatarSelectorsImgs.length; i++) {
        avatarSelectorsImgs[i].addEventListener("click", function() {

            var avatarId = this.id.split('-')[1];

            const srcSegments = this.src.split('/');
            const url = srcSegments[srcSegments.length - 1];
            overlay.classList.remove("active");
            //añadir aqui el fetch para que envie al server la imagen que se ha seleccionado
            fetch(`http://localhost/tfg/4squares/controller/userController.php?updateAvatar=true&userId=<?php echo $userId ?>&avatarId=${avatarId}&avatarUrl=${url}`, {
                    method: 'GET'
                })
                .then(response => {
                    if (response.ok) {
                        avatarImg.src = this.src;
                        navImg.src = this.src;

                        // alert('avatar actualizado');
                    } else {
                        alert('No se pudo actualizar el avatar.');
                    }
                })
                .catch(error => {
                    alert('No se pudo actualizar el avatar.');
                });
        });
    }

    // boton para eliminar favorito
    var deleteFavoriteButtons = document.querySelectorAll('.eliminarBoton');
    for (let i = 0; i < deleteFavoriteButtons.length; i++) {
        deleteFavoriteButtons[i].addEventListener("click", function() {

            var deleteButtonId = this.id.split('-')[1];

            fetch(`http://localhost/tfg/4squares/controller/favoriteController.php?switchFavorite=true&userId=<?php echo $userId ?>&productId=${deleteButtonId}`, {
                    method: 'GET'
                })
                .then(response => {
                    if (response.ok) {
                        this.parentNode.parentNode.remove();
                    } else {
                        alert('No se pudo eliminar favorito.');
                    }
                })
                .catch(error => {
                    alert('No se pudo eliminar favorito.');
                });
        });
    }
</script>

</html>