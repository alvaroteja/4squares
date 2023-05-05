<?php
include("./service/DBConnection.php");
include "./service/ScoreService.php";
include "./service/ReviewService.php";

$connnection = new DBConnection();
$a = new ReviewService($connnection);
$a->saveText("123");
//$r = $a->deleteReview(4);
// if (!$r) {
//     echo "es falso";
// }
//echo "<pre>";
//print_r($r);
