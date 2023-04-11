<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

include("../service/DBConnection.php");
include("../service/ProductService.php");
include("../webSettings.php");
session_start();
$connnection = new DBConnection();
$productService = new ProductService($connnection);

//si no hay lista de IDs de producto o vamos a la page 1, se crea/actualiza
if (!isset($_SESSION["productsIdList"]) || $_SESSION["currentPage"] == 1) {
    $productsIdList = $productService->getAllIdProducts();
    $_SESSION["productsIdList"] = $productsIdList;
    $maxPages = ceil(count($_SESSION["productsIdList"]) / $maxProductsAtHome);
    $_SESSION["maxPages"] = $maxPages;
}

//si el currentPage de session excede el maximo de paginas posibles segun los productos en la base de datos, se pone el currentPage de session en el maximo
if ($_SESSION["currentPage"] > $_SESSION["maxPages"]) {
    $_SESSION["currentPage"] = $_SESSION["maxPages"];
}

//Crea una lista de objetos producto que se va a mostrar en la pagina
$productsIdList = $_SESSION['productsIdList'];
$productsList = array();
$i = $maxProductsAtHome * $_SESSION["currentPage"] - $maxProductsAtHome;

for ($i; $i < $maxProductsAtHome * $_SESSION["currentPage"]; $i++) {
    if ($i < count($productsIdList)) {
        array_push($productsList, $productService->getAProduct($productsIdList[$i]));
    } else {
        break;
    }
}

$_SESSION["productsList"] = $productsList;

header("Location: ../home.php");
