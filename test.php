<?php
include("./service/DBConnection.php");
include "./service/ScoreService.php";
include "./service/ReviewService.php";
include "./service/UserService.php";
include "./service/FavoriteService.php";
include "./service/ProductService.php";

$connnection = new DBConnection();
$a = new ProductService($connnection);
echo $a->switchProductHideState(1, 1);
//$r = $a->deleteReview(4);
// if (!$r) {
//     echo "es falso";
// }
//echo "<pre>";
//print_r($r);
