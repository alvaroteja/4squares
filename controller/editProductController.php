<?php
include("../model/UserModel.php");
include("../model/ProductModel.php");
include("../service/DBConnection.php");
include("../service/ProductService.php");
session_start();

//si llegamos por el get y el usuario es admin
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SESSION['user']->getCredentials() == 1) {
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
        // echo "<pre>";
        // print_r($productData);
    } else {
        header("Location: ../index.php");
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}
