<?php
session_start();
if (isset($_GET["currentPage"])) {
    $_SESSION["currentPage"] = $_GET["currentPage"];
    header("Location: ./controller/homeController.php?currentPage=" . $_GET['currentPage']);
} else {
    $_SESSION["currentPage"] = 1;
    header("Location: ./controller/homeController.php?currentPage=1");
}
