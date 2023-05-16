<?php
include("../service/DBConnection.php");
include("../service/FavoriteService.php");
include("../dto/userPanelFavoriteDto.php");
include("../model/UserModel.php");
include("../service/ScoreService.php");
include("../service/AvatarService.php");
include("../model/AvatarModel.php");

session_start();

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

$connnection = new DBConnection();
if (!isset($_SESSION["user"])) {
    header("Location: ../login.php");
    exit;
}

//cargar en sesion la lista de favoritos de usuario
$favoriteService = new FavoriteService($connnection);
$userPanelFavoriteDtoList = $favoriteService->getAllFavoritesByUserId($_SESSION["user"]->getId_user());
$_SESSION["userPanelFavoriteList"] = $userPanelFavoriteDtoList;
// echo "<pre>";
// print_r($userPanelFavoriteDtoList);
//cargar en sesion la lista de avatares disponibles
$avatarService = new AvatarService($connnection);
$avatarsList = $avatarService->getAllAvatars();
$_SESSION["avatarsList"] = $avatarsList;
//
$_SESSION['userPanelControllerRedireccion'] = true;
header("Location: ../userPanel.php");
