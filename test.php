<?php
include("./service/DBConnection.php");
include "./service/ScoreService.php";
include "./service/ReviewService.php";
include "./service/UserService.php";

$connnection = new DBConnection();
$a = new UserService($connnection);
echo $a->deleteUser(112);
//$r = $a->deleteReview(4);
// if (!$r) {
//     echo "es falso";
// }
//echo "<pre>";
//print_r($r);
