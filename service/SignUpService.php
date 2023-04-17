<?php
include_once("../generalData/messages.php");

class SignUpService
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
        //valido el campo nombre, si hay algun error se añaden a $errorList
        if ($errors = $this->validateName($inputList["name"])) {
            $errorList["name"] =  $errors;
        }
        //valido el campo apellido, si hay algun error se añaden a $errorList
        if ($errors = $this->validateSurname($inputList["surname"])) {
            $errorList["surname"] =  $errors;
        }
        //valido el campo email, si hay algun error se añaden a $errorList
        if ($errors = $this->validateEmail($inputList["email"])) {
            $errorList["email"] =  $errors;
        }
        if ($errors = $this->validateUserName($inputList["userName"])) {
            $errorList["userName"] =  $errors;
        }
        return $errorList;
    }
    function validateName($name)
    {
        $nameErrorList = array();
        //voy añadiendo los errores a $nameErrorList
        if ($error = $this->isEmpty($name)) {
            $nameErrorList[] = $error;
            return $nameErrorList;
        }
        if ($error = $this->thereAreOuterBlankSpaces($name)) {
            $nameErrorList[] = $error;
        }
        if ($error = $this->hasInvalidCharacters($name)) {
            $nameErrorList[] = $error;
            return $nameErrorList;
        }

        //si hay errores en la lista retorno la lista, si no, retorno false
        if (count($nameErrorList) > 0) {
            return $nameErrorList;
        }
        return false;
    }

    function validateSurname($surname)
    {
        $surnameErrorList = array();
        //voy añadiendo los errores a $surnameErrorList
        if ($error = $this->isEmpty($surname)) {
            $surnameErrorList[] = $error;
            return $surnameErrorList;
        }
        if ($error = $this->thereAreOuterBlankSpaces($surname)) {
            $surnameErrorList[] = $error;
        }
        if ($error = $this->hasInvalidCharacters($surname)) {
            $surnameErrorList[] = $error;
            return $surnameErrorList;
        }

        //si hay errores en la lista retorno la lista, si no, retorno false
        if (count($surnameErrorList) > 0) {
            return $surnameErrorList;
        }
        return false;
    }

    function validateEmail($email)
    {
        $emailErrorList = array();
        //voy añadiendo los errores a $emailErrorList
        if ($error = $this->isEmpty($email)) {
            $emailErrorList[] = $error;
            return $emailErrorList;
        }
        if ($error = $this->thereAreOuterBlankSpaces($email)) {
            $emailErrorList[] = $error;
        }
        if ($error = $this->thereAreBlankSpaces($email)) {
            $emailErrorList[] = $error;
            return $emailErrorList;
        }
        if ($error = $this->isInvalidEmail($email)) {
            $emailErrorList[] = $error;
        }

        //si hay errores en la lista retorno la lista, si no, retorno false
        if (count($emailErrorList) > 0) {
            return $emailErrorList;
        }
        return false;
    }

    function validateUserName($userName)
    {
        $userNameErrorList = array();
        //voy añadiendo los errores a $emailErrorList
        if ($error = $this->isEmpty($userName)) {
            $userNameErrorList[] = $error;
            return $userNameErrorList;
        }
        if ($error = $this->thereAreBlankSpaces($userName)) {
            $userNameErrorList[] = $error;
            return $userNameErrorList;
        }
        if ($error = $this->userNameExist($userName)) {
            $userNameErrorList[] = $error;
            return $userNameErrorList;
        }
        if ($error = $this->hasInvalidCharactersButNumbersAreSupported($userName)) {
            $userNameErrorList[] = $error;
            return $userNameErrorList;
        }

        //si hay errores en la lista retorno la lista, si no, retorno false
        if (count($userNameErrorList) > 0) {
            return $userNameErrorList;
        }
        return false;
    }


    function isEmpty($value)
    {
        if (!isset($value) || is_null($value) || empty($value) || $value == "") {
            return "El campo está vacio.";
        }
        return false;
    }

    function thereAreOuterBlankSpaces($value)
    {
        $firstLength = strlen($value);
        $value = trim($value, " ");
        $secondLength = strlen($value);

        if ($firstLength != $secondLength) {
            return "No puede haber espacios en blanco al principio ni al final.";
        }

        return false;
    }
    function thereAreBlankSpaces($value)
    {
        if (str_contains($value, ' ')) {
            return "Es campo no puede contener espacios en blanco.";
        }

        return false;
    }


    function isInvalidEmail($str)
    {
        if (!filter_var($str, FILTER_VALIDATE_EMAIL)) {
            return "Este email no tiene un formato correcto.";
        }
        return false;
    }

    function userNameExist($userName)
    {
        $con = $this->connnection->getConnection();

        $query = "SELECT * FROM `users` WHERE nickname = '" . $userName . "'";
        $resultset = $con->query($query);

        if ($resultset->num_rows == 0) {
            mysqli_close($con);

            return false;
        }

        return "Este Nombre de usuario ya existe.";
    }

    function hasInvalidCharacters($string)
    {
        //"/[^A-Za-z'-'_' ']/
        //'^[a-zA-Z0-9\-_]{3,20}$'
        if (!preg_match("/^[a-zA-Z0-9á-úÁ-Úä-üÄ-ÜñÑçÇ\s]{1,15}$/", $string)) {
            return "El nombre no puede contener caracteres especiales o numeros y su longitud máxima es de 15 caracteres.";
        }
        return false;
    }
    function hasInvalidCharactersButNumbersAreSupported($string)
    {
        //"/[^A-Za-z'-'_' ']/
        //'^[a-zA-Z0-9\-_]{3,20}$'
        if (!preg_match("/^[a-zA-Z0-9á-úÁ-Úä-üÄ-ÜñÑçÇ\s]{1,15}$/", $string)) {
            return "El nombre no puede contener caracteres especiales y su longitud máxima es de 15 caracteres.";
        }
        return false;
    }
}
