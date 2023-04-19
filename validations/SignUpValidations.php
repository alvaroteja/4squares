<?php

class SignUpValidations
{
    protected $connnection;
    protected $Messages;
    public function __construct($connnection, $Messages)
    {
        $this->connnection = $connnection;
        $this->Messages = $Messages;
    }
    //creo una lista con los errores que hay en los distintos campos
    function validateInputs($inputList)
    {
        $errorList = array();

        if ($errors = $this->validateName($inputList["name"])) {
            $errorList["name"] =  $errors;
        }
        if ($errors = $this->validateSurname($inputList["surname"])) {
            $errorList["surname"] =  $errors;
        }
        if ($errors = $this->validateEmail($inputList["email"])) {
            $errorList["email"] =  $errors;
        }
        if ($errors = $this->validateUserName($inputList["userName"])) {
            $errorList["userName"] =  $errors;
        }
        if ($errors = $this->validatePassword($inputList["password"])) {
            $errorList["password"] =  $errors;
        }
        if ($errors = $this->differentInputs($inputList["password"], $inputList["password2"])) {
            $errorList["password2"] =  $errors;
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
        }
        if ($error = $this->execedMaxLength($name, 50)) {
            $nameErrorList[] = $error;
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
        }
        if ($error = $this->execedMaxLength($surname, 50)) {
            $surnameErrorList[] = $error;
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
        if ($error = $this->thereAreBlankSpaces($email)) {
            $emailErrorList[] = $error;
        }
        if ($error = $this->isInvalidEmail($email)) {
            $emailErrorList[] = $error;
        }
        if ($error = $this->execedMaxLength($email, 254)) {
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
        //voy añadiendo los errores a $userNameErrorList
        if ($error = $this->isEmpty($userName)) {
            $userNameErrorList[] = $error;
            return $userNameErrorList;
        }
        if ($error = $this->thereAreBlankSpaces($userName)) {
            $userNameErrorList[] = $error;
        }
        if ($error = $this->hasInvalidCharactersButNumbersAreSupported($userName)) {
            $userNameErrorList[] = $error;
        }
        if ($error = $this->execedMaxLength($userName, 50)) {
            $userNameErrorList[] = $error;
        }
        if ($error = $this->userNameExist($userName)) {
            $userNameErrorList[] = $error;
            return $userNameErrorList;
        }

        //si hay errores en la lista retorno la lista, si no, retorno false
        if (count($userNameErrorList) > 0) {
            return $userNameErrorList;
        }
        return false;
    }

    function validatePassword($password)
    {
        $passwordErrorList = array();
        //voy añadiendo los errores a $passwordErrorList
        if ($error = $this->isEmpty($password)) {
            $passwordErrorList[] = $error;
            return $passwordErrorList;
        }
        if ($error = $this->thereAreBlankSpaces($password)) {
            $passwordErrorList[] = $error;
        }
        if ($error = $this->lessThan8Character($password)) {
            $passwordErrorList[] = $error;
        }
        if ($error = $this->noUppercaseletter($password)) {
            $passwordErrorList[] = $error;
        }
        if ($error = $this->noLowcaseletter($password)) {
            $passwordErrorList[] = $error;
        }
        if ($error = $this->noDigit($password)) {
            $passwordErrorList[] = $error;
        }
        if ($error = $this->noSpecialCharacter($password)) {
            $passwordErrorList[] = $error;
        }
        if ($error = $this->execedMaxLength($password, 50)) {
            $passwordErrorList[] = $error;
        }

        //si hay errores en la lista retorno la lista, si no, retorno false
        if (count($passwordErrorList) > 0) {
            return $passwordErrorList;
        }
        return false;
    }

    //////////////////////////////
    // FUNCIONES DE VALIDACION  //
    //////////////////////////////

    function isEmpty($value)
    {
        if (!isset($value) || is_null($value) || empty($value) || $value == "") {
            return $this->Messages->getEmptyField();
        }
        return false;
    }

    function thereAreOuterBlankSpaces($value)
    {
        $firstLength = strlen($value);
        $value = trim($value, " ");
        $secondLength = strlen($value);

        if ($firstLength != $secondLength) {
            return $this->Messages->getOuterBlankSpaces();
        }

        return false;
    }
    function thereAreBlankSpaces($value)
    {
        if (str_contains($value, ' ')) {
            return $this->Messages->getBlankSpaces();
        }
        return false;
    }


    function isInvalidEmail($str)
    {
        if (!filter_var($str, FILTER_VALIDATE_EMAIL)) {
            return $this->Messages->getInvalidEmail();
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

        return $this->Messages->getUserNameExist();
    }

    function hasInvalidCharacters($string)
    {
        //"/[^A-Za-z'-'_' ']/
        //'^[a-zA-Z0-9\-_]{3,20}$'
        if (!preg_match("/^[a-zA-Zá-úÁ-Úä-üÄ-ÜñÑçÇ\s]+$/i", $string)) {
            return $this->Messages->getInvalidCharacters();
        }
        return false;
    }
    function hasInvalidCharactersButNumbersAreSupported($string)
    {
        //"/[^A-Za-z'-'_' ']/
        //'^[a-zA-Z0-9\-_]{3,20}$'
        if (!preg_match("/^[a-zA-Z0-9á-úÁ-Úä-üÄ-ÜñÑçÇ\s]+$/i", $string)) {
            return $this->Messages->getInvalidCharactersButNumbersAreSupported();
        }
        return false;
    }

    function execedMaxLength($string, $maxLength)
    {
        if (strlen($string) > $maxLength) {
            return $this->Messages->getExecedMaxLength() . $maxLength . ".";
        }
        return false;
    }

    function invalidPasswordFormat($string)
    {
        /*
         Has minimum 8 characters in length. Adjust it by modifying {8,}
         At least one uppercase English letter. You can remove this condition by removing (?=.*?[A-Z])
         At least one lowercase English letter.  You can remove this condition by removing (?=.*?[a-z])
         At least one digit. You can remove this condition by removing (?=.*?[0-9])
         At least one special character,  You can remove this condition by removing (?=.*?[#?!@$%^&*-])
         */
        if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $string)) {
            return $this->Messages->getPasswordNotValid();
        }
        return false;
    }
    function lessThan8Character($string)
    {
        if (!preg_match("/^.{8,}$/", $string)) {
            return $this->Messages->getLessThan8Characteres();
        }
        return false;
    }
    function noUppercaseletter($string)
    {
        if (!preg_match("/.*[A-Z]/", $string)) {
            return $this->Messages->getNoUppercaseletter();
        }
        return false;
    }
    function noLowcaseletter($string)
    {
        if (!preg_match("/.*[a-z]/", $string)) {
            return $this->Messages->getNoLowcaseletter();
        }
        return false;
    }
    function noDigit($string)
    {
        if (!preg_match("/.*[0-9]/", $string)) {
            return $this->Messages->getNoDigit();
        }
        return false;
    }
    function noSpecialCharacter($string)
    {
        if (!preg_match("/.*[#?!@$%^&*-]/", $string)) {
            return $this->Messages->getNoSpecialCharacter();
        }
        return false;
    }

    function differentInputs($input1, $input2)
    {
        $errorList = array();

        if ($input1 != $input2) {
            $errorList[] = $this->Messages->getDifferentInputs();
            return $errorList;
        }
        return false;
    }
}
