<?php
include("../service/DBConnection.php");
include("../service/ProductService.php");
include("../service/ScoreService.php");
include("../model/ProductModel.php");
include("../webSettings.php");
include("../model/UserModel.php");
session_start();

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

$connnection = new DBConnection();
$productService = new ProductService($connnection);

//si no hay lista de IDs de producto o vamos a la page 1, se crea/actualiza
if (!isset($_SESSION["productsIdList"]) || $_SESSION["currentPage"] == 1) {
    //Si el usuario es admin, la lista tendra tambien los productos ocultos, si no es admin, no se veran los productos ocultos
    if (isset($_SESSION["user"]) && $_SESSION["user"]->getCredentials() == 1) {
        $productsIdList = $productService->getAllIdProducts();
    } else {
        $productsIdList = $productService->getAllIdProductsNotHidden();
    }

    $_SESSION["productsIdList"] = $productsIdList;
    $maxPages = ceil(count($_SESSION["productsIdList"]) / $maxProductsAtHome);
    $_SESSION["maxPages"] = $maxPages;
}

//si el currentPage de session excede el maximo de paginas posibles segun los productos en la base de datos, se pone el currentPage de session en el maximo
if ($_SESSION["currentPage"] > $_SESSION["maxPages"]) {
    $_SESSION["currentPage"] = $_SESSION["maxPages"];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['filterRequest']) {

    $serachInput = $_POST["serachInput"];
    // echo "<pre>";
    // print_r($_POST);

    $productsIdList = $productService->getIdProductsByFilter($_POST);

    $_SESSION["productsIdList"] = $productsIdList;
    $maxPages = ceil(count($_SESSION["productsIdList"]) / $maxProductsAtHome);
    $_SESSION["maxPages"] = $maxPages;

    //para el repintado de los filtros
    $filterValues = [];
    foreach ($_POST as $key => $value) {
        $filterValues[$key] = $value;
        $_SESSION[$key] = $value;
    }
    $_SESSION["filterValues"] = $filterValues;
    // echo "<pre>";
    // print_r($_SESSION);
    // exit;
}

//Crea una lista de objetos producto que se va a mostrar en la pagina
$productsIdList = $_SESSION['productsIdList'];
$productsList = array();
$i = $maxProductsAtHome * $_SESSION["currentPage"] - $maxProductsAtHome;

for ($i; $i < $maxProductsAtHome * $_SESSION["currentPage"]; $i++) {
    if ($i < count($productsIdList)) {
        $product = $productService->getAProduct($productsIdList[$i]);
        //aqui añadir a cada producto de la lista su media de score actual con un scoreService
        $scoreService = new ScoreService($connnection);
        $averageScore = $scoreService->getAverageScore($productsIdList[$i]);
        $product->setAverageScore($averageScore);
        array_push($productsList, $product);
    } else {
        break;
    }
}

$typesList = $productService->getAllTypes();
$_SESSION['typesList'] = $typesList;

$categoriesList = $productService->getAllCategories();
$_SESSION['categoriesList'] = $categoriesList;

$publishersList = $productService->getAllPublishers();
$_SESSION['publishersList'] = $publishersList;

$_SESSION["productsList"] = $productsList;

header("Location: ../home.php");
