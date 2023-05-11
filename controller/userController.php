<?php
include("../service/DBConnection.php");
include("../service/userService.php");
include("../model/UserModel.php");

$connnection = new DBConnection();
//si se llega aqui para mutear un usuario
if (isset($_GET["muteUser"])) {
    $userService = new UserService($connnection);
    $userService->muteUser($_GET["id"], $_GET["value"]);
}

//si se llega aqui para borrar un usuario
if (isset($_GET["deleteUser"])) {
    $userService = new UserService($connnection);
    $userService->deleteUser($_GET["userId"]);
}

//si se llega aqui para actualizar el avatar de usuario
if (isset($_GET["updateAvatar"])) {
    session_start();
    $userService = new UserService($connnection);
    $userService->updateAvatar($_GET["userId"], $_GET["avatarId"]);
    $_SESSION["user"]->setId_avatar($_GET["avatarUrl"]);
}
