<?php
include("../service/DBConnection.php");
include("../service/ProductService.php");
include("../model/ProductModel.php");


session_start();
//si no hay id o está vacio, mandamos a index
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: ../index.php");
}
$currentProductId = $_GET["id"];

$connnection = new DBConnection();
$productService = new ProductService($connnection);

//si el producto no existe, mandamos a index
if (!$product = $productService->getAProduct($currentProductId)) {
    header("Location: ../index.php");
}

$_SESSION["currentProduct"] = $product;
header("Location: ../productInfo.php");
