<?php
include("./service/DBConnection.php");
include "./service/ScoreService.php";
include "./service/ReviewService.php";
include "./service/addProductService.php";
include "./service/UserService.php";
include "./service/FavoriteService.php";
include "./service/ProductService.php";
include "./dto/userPanelFavoriteDto.php";
include "./model/AvatarModel.php";

$connnection = new DBConnection();
$a = new AddProductService($connnection);
$b = $a->checkIfSelectExist("category", "Estratasdegia");
echo "<pre>";
print_r($b);

//$r = $a->deleteReview(4);
// if (!$r) {
//     echo "es falso";
// }
//echo "<pre>";
//print_r($r);
