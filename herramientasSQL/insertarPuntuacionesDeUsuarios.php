<?php
//include("../service/DBConnection.php");
include("../service/ProductService.php");
echo "<pre>";
//conexion
$conexion = new DBConnection();
$con = $conexion->getConnection();

//lista id productos
$pservice = new ProductService();
$listaProductos = $pservice->getAllIdProducts();
//print_r($listaProductos);


//lista Id usuarios
$listaUsuarios = array();
$query = "SELECT id FROM `users`;";
$resultset = $con->query($query);
foreach ($resultset as $result) {
    array_push($listaUsuarios, $result['id']);
}
//print_r($listaUsuarios);


echo (rand(0, 5));

foreach ($listaUsuarios as $usuario) {
    foreach ($listaProductos as $producto) {
        echo ("INSERT INTO `scores` (`id`, `id_product`, `id_user`, `score`) VALUES (NULL, '$producto', '$usuario', '" . rand(0, 5) . "');" . "<br>");
    }
}
