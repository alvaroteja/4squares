<?php
include("service/DBConnection.php");
include("service/ReviewService.php");
include("dto/reviewDto.php");
$connnection = new DBConnection();
$reviewService = new ReviewService($connnection);
$reviewService->getAllReviewsById(1);
