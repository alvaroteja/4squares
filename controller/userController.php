<?php
include("../service/DBConnection.php");
include("../service/userService.php");

$connnection = new DBConnection();
//si se llega aqui para mutear un usuario
if (isset($_GET["muteUser"])) {
    $userService = new UserService($connnection);
    $userService->muteUser($_GET["id"], $_GET["value"]);
}

//si se llega aqui borrar un usuario
if (isset($_GET["deleteUser"])) {
    $userService = new UserService($connnection);
    $userService->deleteUser($_GET["userId"]);
}
