<?php
include("../service/DBConnection.php");
include("../service/LoginService.php");
include("../service/AvatarService.php");

session_start();

//Si ya está logeado el usuario, vamos a logout
if (isset($_SESSION['user'])) {
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: ../index.php");
    } else {
        header("Location: ../logout.php");
    }
} else {

    //Si venimos por el post, validar datos
    if (isset($_POST['login'])) {

        $connnection = new DBConnection();
        $loginService = new LoginService($connnection);
        $errorList = $loginService->validateInputs($_POST);

        //Si hay errores los pasamos por el get a la vista
        if (gettype($errorList) != "object" && count($errorList) > 0) {
            //generamos el get
            $getString = "?";
            if (!isset($errorList['userName'])) {
                $getString = $getString . "userName=" . $_POST['userName'] . "&";
            }
            foreach ($errorList as $key => $value) {
                if ($value == "empty") {
                    $getString = $getString . $key . "=" . $value . "&";
                }
            }
            if (isset($errorList['userName']) && $errorList['userName'] == "noMatches" || isset($errorList['password']) && $errorList['password'] == "noMatches") {
                $getString = $getString . "userName=" . $_POST['userName'] . "&";
                $getString = $getString . "userOrPass=noMatches&";
            }


            $getString = trim($getString, "&");

            header("Location: ../login.php$getString");
        }
        //si todo ha ido bien, obtenemos un objeto usuario con sus datos, lo metemos en session y vamos a la home
        else {
            //cambio el id del avatar del usuario registrado por la url de la imagen
            $avatarService = new AvatarService($connnection);
            $avatarUrl = $avatarService->getAvatarByID($errorList->getId_avatar());
            $errorList->setId_avatar($avatarUrl);

            $_SESSION['user'] = $errorList;
            header("Location: ../index.php");
        }
    }
    //Si no venimos por el post, mandar a hacer login
    else {
        header("Location: ../login.php");
    }
}
