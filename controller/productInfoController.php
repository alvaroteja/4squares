<?php
include("../service/DBConnection.php");
include("../service/ProductService.php");
include("../model/ProductModel.php");
include("../model/UserModel.php");
include("../service/ScoreService.php");
include("../dto/reviewDto.php");
include("../service/ReviewService.php");
include("../service/FavoriteService.php");

session_start();

$connnection = new DBConnection();
$ancla = "";
//si se llega aqui para guardar un comentario
if (isset($_POST["writeComment"])) {
    if (strlen($_POST['review']) > 0) {
        $reviewService = new ReviewService($connnection);
        $reviewService->writeReview($_POST['id_product'], $_POST['id_user'], $_POST['review']);
    } else {
        $error = "El mensaje no ha sido guardado ya que estaba vacío.";
        $ancla = "#error";
        $_SESSION["reviewErrorMessage"] = $error;
    }
    $currentProductId = $_POST['id_product'];
}
//si se llega aqui para borrar un comentario
elseif (isset($_GET["deleteReview"])) {
    $reviewService = new ReviewService($connnection);
    $reviewService->deleteReview($_GET["deleteReview"]);
    //$currentProductId = $_POST['id_product'];
}
//si se llega aqui para ocultar un comentario
elseif (isset($_GET["hideReview"])) {
    $reviewService = new ReviewService($connnection);
    $reviewService->hideReview($_GET["hideReview"], $_GET["value"]);
    //$currentProductId = $_POST['id_product'];
}
//si se llega aqui para votar el producto
elseif (isset($_POST["score"])) {
    $scoreService = new ScoreService($connnection);
    $scoreService->insertScore($_POST['id_product'], $_POST['id_user'], $_POST['score']);
    $currentProductId = $_POST['id_product'];
}
//si se llega aqui para cambiar una votacion
elseif (isset($_POST["changingScore"])) {
    $scoreService = new ScoreService($connnection);
    $scoreService->updateScore($_POST['id_product'], $_POST['id_user'], $_POST['changingScore']);
    $currentProductId = $_POST['id_product'];
}
//si se consigue llegar aquí sin id de producto, mandamos a index y si viene el id por el get, lo pillamos
else {
    //si no hay id o está vacio, mandamos a index
    if (!isset($_GET["id"]) || empty($_GET["id"])) {
        header("Location: ../index.php");
        exit;
    }
    $currentProductId = $_GET["id"];
    unset($_GET["id"]);
}

$productService = new ProductService($connnection);
$product = $productService->getAProduct($currentProductId);

//si el producto no existe, mandamos a index
if (!$product) {
    header("Location: ../index.php");
    exit;
}

//consigo la puntuacion media del producto
$scoreService = new ScoreService($connnection);
$averageScore = $scoreService->getAverageScore($currentProductId);

//hago una lista de objetos review con los datos de cada comentario
$reviewService = new ReviewService($connnection);
$reviewList = $reviewService->getAllReviewsById($currentProductId);

//Miro si el producto ya ha sido votado por el user
if (isset($_SESSION['user'])) {
    $vote = $reviewService->hasBeenVotedByUserId($currentProductId, $_SESSION['user']->getId_user());
    $_SESSION["productScoreByUser"] = $vote;
}

//Miro si el producto está en la lista de favoritos del usuario
if (isset($_SESSION['user'])) {
    $favoriteService = new FavoriteService($connnection);
    $isAFavoriteProduct = $favoriteService->checkIfFavoriteByUserId($currentProductId, $_SESSION['user']->getId_user());
    $_SESSION["isAFavoriteProduct"] = $isAFavoriteProduct;
}

$_SESSION["currentProduct"] = $product;
$_SESSION["currentAverageScore"] = $averageScore;
$_SESSION["currentReviewList"] = $reviewList;

$_SESSION['redireccion'] = true;
header("Location: ../productInfo.php$ancla");
