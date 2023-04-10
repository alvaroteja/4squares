<?php

class DBConnection
{
    private $hostname = "localhost";
    private $user = "root";
    private $password = "";
    private $dataBase = "4squares";

    function getConnection()
    {
        try {
            $connection = new mysqli($this->hostname, $this->user, $this->password, $this->dataBase);
            if ($connection->connect_errno) {
                echo "Fallo al conectar a MySQL: (" . $connection->connect_errno . ") " . $connection->connect_error;
                return false;
            }

            return $connection;
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            return false;
        }
    }
}
