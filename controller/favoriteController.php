<?php
include("../service/DBConnection.php");
include("../service/FavoriteService.php");

$connnection = new DBConnection();
//si se llega aqui para agregar o eliminar favorito
if (isset($_GET["switchFavorite"])) {
    $favoriteService = new FavoriteService($connnection);
    $favoriteService->switchFavoriteByUserId($_GET["productId"], $_GET["userId"]);
}
