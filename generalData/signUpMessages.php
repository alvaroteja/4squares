<?php



/////////////
//  Login  //
/////////////

//mensaje para cuando es usuario no introduce correo
$loginUserNameMessage = "Introduzca un nombre de usuario o correo electrónico.";

//mensaje para cuando es usuario no introduce contraseña
$loginPasswordMessage = "Introduzca una contraseña.";

//mensaje para cuando el usuario y/o la contraseña no coinciden
$loginErrorMessage = "Usuario y/o contraseña no son válidos.";

class SignUpMessages
{
    var $emptyField = "El campo está vacío.";
    var $outerBlankSpaces = "No puede haber espacios en blanco al principio ni al final.";
    var $blankSpaces = "El campo no puede contener espacios en blanco.";
    var $invalidEmail = "Este email no tiene un formato correcto.";
    var $userNameExist = "Este Nombre de usuario ya existe.";
    var $invalidCharacters = "El nombre no puede contener números ni caracteres especiales.";
    var $invalidCharactersButNumbersAreSupported = "El nombre no puede contener caracteres especiales.";
    var $execedMaxLength = "El número máximo de caracteres es de ";
    var $passwordNotValid = "Password no válido.";
    var $lessThan8Characteres  = "Hay menos de 8 caracteres.";
    var $noUppercaseletter = "Se necesita al menos una mayúscula.";
    var $noLowcaseletter = "Se necesita al menos una minúscula.";
    var $noDigit = "Se necesita al menos un número.";
    var $noSpecialCharacter = "Se necesita al menos un carácter especial.";
    var $differentInputs = "Los campos no coinciden.";

    public function getEmptyField()
    {
        return $this->emptyField;
    }
    public function getOuterBlankSpaces()
    {
        return $this->outerBlankSpaces;
    }
    public function getBlankSpaces()
    {
        return $this->blankSpaces;
    }
    public function getInvalidEmail()
    {
        return $this->invalidEmail;
    }
    public function getUserNameExist()
    {
        return $this->userNameExist;
    }
    public function getInvalidCharacters()
    {
        return $this->invalidCharacters;
    }
    public function getInvalidCharactersButNumbersAreSupported()
    {
        return $this->invalidCharactersButNumbersAreSupported;
    }
    public function getExecedMaxLength()
    {
        return $this->execedMaxLength;
    }
    public function getPasswordNotValid()
    {
        return $this->passwordNotValid;
    }
    public function getLessThan8Characteres()
    {
        return $this->lessThan8Characteres;
    }
    public function getNoUppercaseletter()
    {
        return $this->noUppercaseletter;
    }
    public function getNoLowcaseletter()
    {
        return $this->noLowcaseletter;
    }
    public function getNoDigit()
    {
        return $this->noDigit;
    }
    public function getNoSpecialCharacter()
    {
        return $this->noSpecialCharacter;
    }
    public function getDifferentInputs()
    {
        return $this->differentInputs;
    }
}
