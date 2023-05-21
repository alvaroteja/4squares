<?php
include("../model/UserModel.php");
include("../service/addProductService.php");
include("../service/DBConnection.php");
session_start();

if (!isset($_SESSION["user"]) || !$_SESSION["user"]->getCredentials() == 1) {
    header("Location: ../index.php");
    exit;
}
if (isset($_POST["sendingForm"])) {
    unset($_POST["sendingForm"]);
    $connnection = new DBConnection();
    $addProductService = new AddProductService($connnection);
    $filters = $addProductService->validateInputs($_POST);
    $response = array('message' => $filters);
    echo json_encode($response);
    exit;
}

$connnection = new DBConnection();
$addProductService = new AddProductService($connnection);

$typesList = $addProductService->getAllTypes();
$_SESSION['typesList'] = $typesList;

$categoriesList = $addProductService->getAllCategories();
$_SESSION['categoriesList'] = $categoriesList;

$publishersList = $addProductService->getAllPublishers();
$_SESSION['publishersList'] = $publishersList;

$_SESSION['redireccion'] = "addProductController";

header("Location: ../addProduct.php");
