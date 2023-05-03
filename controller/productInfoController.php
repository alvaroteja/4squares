<?php
include("../service/DBConnection.php");
include("../service/ProductService.php");
include("../model/ProductModel.php");
include("../model/UserModel.php");
include("../service/ScoreService.php");
include("../dto/reviewDto.php");
include("../service/ReviewService.php");

session_start();

$connnection = new DBConnection();
$ancla = "";
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
    // header("Location: ../productInfo.php");
    // exit;
} else {
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

$_SESSION["currentProduct"] = $product;
$_SESSION["currentAverageScore"] = $averageScore;
$_SESSION["currentReviewList"] = $reviewList;
header("Location: ../productInfo.php$ancla");
