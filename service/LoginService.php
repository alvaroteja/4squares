<?php
include("../model/UserModel.php");
class LoginService
{
    var $user;

    protected $connnection;


    public function __construct($connnection)
    {
        $this->connnection = $connnection;
    }

    function validateInputs($inputList)
    {
        $errorList = array();

        //si hay algun campo vacio
        foreach ($inputList as $key => $value) {
            if ($this->isEmpty($key, $value)) {
                $errorList += [$key => "empty"];
            }
        }
        if (count($errorList) > 0) {
            return $errorList;
        }

        //mira si existe el usuario
        $userNameValidation = $this->userNameExist($inputList['userName']);

        //si no existe usuario, añade el error y sale
        if (!$userNameValidation) {
            $errorList += ["userName" => "noMatches"];
            return $errorList;
        }

        //si no coincide la contraseña, añade el error
        if ($userNameValidation != $inputList['password']) {
            $errorList += ["password" => "noMatches"];
            return $errorList;
        }

        return $this->user;
    }
    function isEmpty($key, $value)
    {
        $isEmpty = false;

        $value = trim($value, " ");

        if (!isset($value) || is_null($value) || empty($value) || $value == "") {
            $isEmpty = true;
        }

        return $isEmpty;
    }

    function userNameExist($userName)
    {
        $con = $this->connnection->getConnection();

        $query = "SELECT * FROM `users` WHERE nickname = '" . $userName . "' or email ='" . $userName . "'";
        $resultset = $con->query($query);

        if ($resultset->num_rows == 0) {

            mysqli_close($con);
            return false;
        } else {

            $row = $resultset->fetch_array(MYSQLI_ASSOC);
            $r = array_values($row);

            $userModel = new UserModel($r[0], $r[1], $r[2], $r[3], $r[4], $r[6], $r[8], $r[9]);
            $this->user = $userModel;
            mysqli_close($con);

            return $r[5];
        }
    }
    function validPassword($password)
    {
    }
}
