<?php
include_once("../service/DBConnection.php");
include_once("../service/SignUpService.php");

session_start();

//$connnection = new DBConnection();
//Si ya está logeado el usuario, vamos a logout
if (isset($_SESSION['user'])) {
    header("Location: ../logout.php");
} else {
    //Si venimos por el post, validar datos
    if (isset($_POST['signUp'])) {
        //echo "<pre>";
        //echo "esto es el post";
        //print_r($_POST);

        $connnection = new DBConnection();
        $signUpService = new SignUpService($connnection);
        $errorList = $signUpService->validateInputs($_POST);
        echo "<pre>";
        echo "esto es la lista de errores:<br>";
        print_r($errorList);
        //Si hay errores los pasamos por el get a la vista
        // if (gettype($errorList) != "object" && count($errorList) > 0) {
        //     //generamos el get
        //     $getString = "?";
        //     if (!isset($errorList['userName'])) {
        //         $getString = $getString . "userName=" . $_POST['userName'] . "&";
        //     }
        //     foreach ($errorList as $key => $value) {
        //         if ($value == "empty") {
        //             $getString = $getString . $key . "=" . $value . "&";
        //         }
        //     }
        //     if (isset($errorList['userName']) && $errorList['userName'] == "noMatches" || isset($errorList['password']) && $errorList['password'] == "noMatches") {
        //         $getString = $getString . "userName=" . $_POST['userName'] . "&";
        //         $getString = $getString . "userOrPass=noMatches&";
        //     }


        //     $getString = trim($getString, "&");

        //     header("Location: ../login.php$getString");
        // }
        // //si todo ha ido bien, obtenemos un objeto usuario con sus datos, lo metemos en session y vamos a la home
        // else {
        //     $_SESSION['user'] = $errorList;
        //     header("Location: ../index.php");
        // }
    }
    //Si no venimos por el post, mandar a hacer logout
    else {
        header("Location: ../logout.php");
    }
}
