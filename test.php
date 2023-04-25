<?php
include("service/DBConnection.php");
include("service/AvatarService.php");
$connnection = new DBConnection();
$avatarService = new AvatarService($connnection);
print_r($avatarService->getAvatarByID(0));
