<?php
include("../service/DBConnection.php");
include("../service/ProductService.php");

$connnection = new DBConnection();
//si se llega aqui para ocultar o visualizar producto
if (isset($_GET["switchProductHideState"])) {
    $productService = new ProductService($connnection);
    $respuesta =  $productService->switchProductHideState($_GET["productId"], $_GET["value"]);
}
//si se llega aqui para eliminar producto
if (isset($_GET["deleteProduct"])) {

    $productService = new ProductService($connnection);
    $productService->deleteProductById($_GET["productId"]);
}
