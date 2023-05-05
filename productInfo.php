<?php
include("service/AvatarService.php");
include("./model/UserModel.php");
include("./service/DBConnection.php");
include_once("model/ProductModel.php");
include("./dto/reviewDto.php");


session_start();

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
    ?><div class="info-container">
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
                        echo ('<div class="carousel-item">
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
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productId-2" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
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
    <div id="social-container">
        <?php
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

        if (!empty($currentReviewList)) {
            for ($i = count($currentReviewList) - 1; $i >= 0; $i--) {
                //print_r($currentReviewList[$i]);
                //echo $currentReviewList[$i]->getIdUser() . "aaaa";
                $deleteIcon = "";
                $idReview = $currentReviewList[$i]->getIdReview();
                if (isset($_SESSION["user"]) && $currentReviewList[$i]->getIdUser() == $_SESSION["user"]->getId_user()) {
                    $deleteIcon = "
                    <svg id='deleteIconReviewId-$idReview' class='deleteSvg deleteIcon' xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                        <polyline class='deleteIcon' points='3 6 5 6 21 6'></polyline>
                        <path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path>
                        <line x1='10' y1='11' x2='10' y2='17'></line>
                        <line x1='14' y1='11' x2='14' y2='17'></line>
                    </svg>
                    ";
                }
                echo ("
                    <div class='user-review'>
                        <hr />
                        <div class='user-review-data'>
                            <p class='user-name'>" . $currentReviewList[$i]->getNickname() . "</p>
                            <div class='dateAndDelete'>
                            <p class='review-date'>" . $currentReviewList[$i]->getDate() . "</p>
                            $deleteIcon
                            </div>
                        </div>
                        <div class='photo-and-review-container'>
                            <img src='./img/avatars/" . $currentReviewList[$i]->getAvatar() . "' alt='' />
                            <p>
                            " . $currentReviewList[$i]->getReview() . "
                            </p>
                        </div>
                    </div>
                ");
            }
        }
        ?>
    </div>
    <?php
    if (isset($_SESSION['user'])) {
        if (isset($_SESSION['productScoreByUser']) && $_SESSION['productScoreByUser']) {
            include("./html/components/productInfoVoteLogedAndVoted.php");
        } else {
            include("./html/components/productInfoVoteLoged.php");
        }
    } else {
        include("./html/components/productInfoVoteNotLoged.php");
    }
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script>
    function toggleClass(element, class1, class2) {
        if (element.classList.contains(class1) && !element.classList.contains(class2)) {
            element.classList.add(class2);
            element.classList.remove(class1);
        } else if (!element.classList.contains(class1) && element.classList.contains(class2)) {
            element.classList.add(class1);
            element.classList.remove(class2);
        }
    }


    var deleteIcons = document.querySelectorAll('.deleteIcon');
    for (var i = 0; i < deleteIcons.length; i++) {
        deleteIcons[i].addEventListener('click', function() {
            alert("boton pulsado");
            var reviewId = this.id.split('-')[1]; // Obtener el ID del comentario a borrar

            const formData = new FormData();
            formData.append('reviewId', reviewId);
            formData.append('deleteReview', true);

            fetch('http://localhost/tfg/4squares/controller/productInfoController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    body: formData
                })
                .then(response => {
                    alert("Ha llegado al server");
                })
                .catch(error => {
                    alert("Ha dado error");
                });
        });
    }
</script>

</html>