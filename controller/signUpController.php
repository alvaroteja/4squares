<?php
include_once("../service/DBConnection.php");
include_once("../service/SignUpService.php");
include_once("../generalData/signUpMessages.php");

session_start();


//Si ya está logeado el usuario, vamos a logout
if (isset($_SESSION['user'])) {
    header("Location: ../logout.php");
} else {
    //Si venimos por el post, validar datos
    if (isset($_POST['signUp'])) {

        $connnection = new DBConnection();
        $singUpMessages = new SignUpMessages();
        $signUpService = new SignUpService($connnection, $singUpMessages);
        $errorList = $signUpService->validateInputs($_POST);

        if ($errorList === true) {
            unset($_SESSION["signUpErrors"]);
            unset($_SESSION["signUpData"]);
            header("Location: ../login.php");
        } else {
            //meto los datos del post en un array para mandarlos de vuelta a la vista y hacer repintado
            $signUpDataList = array();
            foreach ($_POST as $key => $value) {
                $signUpDataList[$key] = $value;
            }
            $_SESSION['signUpData'] = $signUpDataList;
            $_SESSION['signUpErrors'] = $errorList;
            header("Location: ../signUp.php");
        }
    }
    //Si no venimos por el post, mandar a hacer logout
    else {
        header("Location: ../logout.php");
    }
}
