<?php
include_once("../validations/SignUpValidations.php");

class SignUpService
{
    protected $connnection;
    protected $Messages;
    //var $SignUpValidations = new SignUpValidations($connnection, $Messages);
    public function __construct($connnection, $Messages)
    {
        $this->connnection = $connnection;
        $this->Messages = $Messages;
    }


    //creo una lista con los errores que hay en los distintos campos
    function validateInputs($inputList)
    {
        $SignUpValidations = new SignUpValidations($this->connnection, $this->Messages);
        $errorList = $SignUpValidations->validateInputs($inputList);

        if (count($errorList) <= 0) {
            $this->createUser($inputList);
            return true;
        }
        return $errorList;
    }

    function createUser($inputList)
    {
        try {
            $con = $this->connnection->getConnection();
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }
            $name = $inputList['name'];
            $surname = $inputList['surname'];
            $email = $inputList['email'];
            $userName = $inputList['userName'];
            $password = $inputList['password'];


            $query = "INSERT INTO `users` (`id`, `first_name`, `surename`, `nickname`, `email`, `password`, `id_avatar`, `sing_up_date`, `muted`, `credentials`) VALUES (NULL, '$name', '$surname', '$userName', '$email', '$password', '1', current_timestamp(), '0', '0');";

            if ($con->query($query) === TRUE) {
                //echo "Se ha creado el usuario satisfactoriamente.";
                $con->close();
                return true;
            } else {
                //echo "Error: " . $query . "<br>" . $con->error;
                $con->close();
                return false;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
}
