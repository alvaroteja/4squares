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
    <title>4squares</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous" />
    <link rel="stylesheet" href="style/userPanel.css" />
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
            <!-- <button id="avatar-btn" class="avatar-btn">Cambiar avatar</button> -->
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
        echo "<pre>";
        // print_r($_SESSION["user"]);
        // print_r($_SESSION["avatarsList"]);
        print_r($userPanelFavoriteList);
        ?>
    </div>
    <div id="favoriteProductsContainer" class="container">
        <?php
        for ($i = 0; $i < count($userPanelFavoriteList); $i++) {
            $aveScor = $userPanelFavoriteList[$i]->getAverageScore();
            $prodName = $userPanelFavoriteList[$i]->getName();
            $prodImg = $userPanelFavoriteList[$i]->getImg();
            echo "
            <div class='favoriteProduct'>
                <img class='favoriteProduct-img' src='./img/products/$prodImg' alt=''/>
                <div class='favoriteProduct-dataContainer'>
                    <h2>$prodName</h2>
                    <div id='score-container'>
                        <div id='product-score-number'>
                            <p>$aveScor</p>
                        </div>
                        <div id='stars'>
            ";
            for ($j = 0; $j < 5; $j++) {
                $class = "starSvgFilled";
                if (round($userPanelFavoriteList[0]->getAverageScore()) < $j + 1) {
                    $class = "starSvgEmpty";
                }
                echo ("
                            <svg class='$class' xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'>
                                <polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'></polygon>
                             </svg>
                ");
            }
            echo "
                        </div>
                    </div>
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
        console.log(overlay.classList);
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
</script>

</html>