<?php
include("../service/DBConnection.php");
include("../service/ProductService.php");
include("../model/ProductModel.php");
include("../service/ScoreService.php");
include("../dto/reviewDto.php");
include("../service/ReviewService.php");

session_start();

//si no hay id o está vacio, mandamos a index
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: ../index.php");
    exit;
}
$currentProductId = $_GET["id"];
unset($_GET["id"]);

$connnection = new DBConnection();
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


$_SESSION["currentProduct"] = $product;
$_SESSION["currentAverageScore"] = $averageScore;
$_SESSION["currentReviewList"] = $reviewList;
header("Location: ../productInfo.php");
