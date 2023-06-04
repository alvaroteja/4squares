<?php
include("../model/UserModel.php");
include("../model/ProductModel.php");
include("../service/DBConnection.php");
include("../service/ProductService.php");
include("../service/AddProductService.php");
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]->getCredentials() != 1) {
    header("Location: ../index.php");
    exit;
}

if (isset($_POST["sendingForm"])) {
    unset($_POST["sendingForm"]);

    $connnection = new DBConnection();
    $addProductService = new AddProductService($connnection);
    $filters = $addProductService->validateUpdateInputs($_POST);

    $response = array(
        'success' => true,
        'message' => 'Todo bien.'
    );
    //si hay errores en los campos los mandamos
    if (count($filters) > 0) {
        $response = array(
            'success' => false,
            'message' => $filters
        );
        echo json_encode($response);
        exit;
    }
    //Si no hay errores en los datos, se actualiza en la BBDD
    $addProductService->updateProductData($_POST);

    //Se guardan las imagenes en el server
    if (count($_FILES) > 0) {
        $response = $addProductService->saveImages($_FILES, $_POST["name"], $_POST["productId"]);

        if (!$response) {
            $response = array(
                'success' => false,
                'message' => 'Error: No se pudo guardar las imágenes.'
            );
            echo json_encode($response);
            exit;
        }
    }
    $deleteImagesList = json_decode($_POST["deleteImagesList"]);

    //si hay imagenes que borrar, se borran
    if (count($deleteImagesList) > 0) {

        $addProductService->deteleImages($deleteImagesList);
    }

    echo json_encode($response);
    exit;
}


//si llegamos por el get y el usuario es admin
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //si hay un productId en la URL
    if (isset($_GET['productId']) && !empty($_GET['productId'])) {

        $connnection = new DBConnection();
        $productService = new ProductService($connnection);
        $productData = $productService->getAProduct($_GET['productId']);
        //$productData->setType($productService->getProductType($productData->getType()));
        $_SESSION["currentEditingProduct"] = $productData;

        $_SESSION['redireccion'] = 'editProductController';

        $typesList = $productService->getAllTypes();
        $_SESSION['typesList'] = $typesList;

        $categoriesList = $productService->getAllCategories();
        $_SESSION['categoriesList'] = $categoriesList;

        $publishersList = $productService->getAllPublishers();
        $_SESSION['publishersList'] = $publishersList;

        header("Location: ../editProduct.php");
        exit;
    } else {
        header("Location: ../index.php");
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}
