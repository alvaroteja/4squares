<?php
include("../model/UserModel.php");
include("../service/addProductService.php");
include("../service/productService.php");
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

    //si hay errores en los campos los mandamos
    if (count($filters) > 0) {
        $response = array(
            'success' => false,
            'message' => $filters
        );
        echo json_encode($response);
        exit;
    }
    //Si no hay errores en los datos, se guardan en la BBDD
    $newProductId =  $addProductService->saveProductData($_POST);

    if (!$newProductId) {
        $response = array(
            'success' => false,
            'message' => 'Error: No se pudo guardar los datos.'
        );
        echo json_encode($response);
        exit;
    }

    //Se guardan las imagenes en el server
    if (count($_FILES) > 0) {
        $response = $addProductService->saveImages($_FILES, $_POST["name"], $newProductId);
        //echo json_encode($response);
        //exit;

        if (!$response) {
            $response = array(
                'success' => false,
                'message' => 'Error: No se pudo guardar las imágenes.'
            );
            echo json_encode($response);
            exit;
        }
    }

    //$response = array('message' => "$newProductId");
    //$response = array('message' => "sin imagenes");
    echo json_encode($response);
    exit;
}

$connnection = new DBConnection();
$productService = new ProductService($connnection);

$typesList = $productService->getAllTypes();
$_SESSION['typesList'] = $typesList;

$categoriesList = $productService->getAllCategories();
$_SESSION['categoriesList'] = $categoriesList;

$publishersList = $productService->getAllPublishers();
$_SESSION['publishersList'] = $publishersList;

$_SESSION['redireccion'] = "addProductController";

header("Location: ../addProduct.php");
