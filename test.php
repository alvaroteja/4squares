<?php
include("./service/DBConnection.php");
include "./service/ReviewService.php";

$connnection = new DBConnection();
$a = new ReviewService($connnection);
$r = $a->hasBeenVotedByUserId(1, 7);
if (!$r) {
    echo "es falso";
}
echo $r;
