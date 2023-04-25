<?php

class AvatarService
{
    protected $connnection;

    public function __construct($connnection)
    {
        $this->connnection = $connnection;
    }

    function getAvatarByID($id_avatar)
    {
        $con = $this->connnection->getConnection();

        $query = "SELECT url FROM `avatars` WHERE id = $id_avatar";
        $resultset = $con->query($query);

        if ($resultset->num_rows == 0) {
            $con->close();
            return false;
        } else {
            $row = $resultset->fetch_array(MYSQLI_ASSOC);
            $con->close();
        }
        return array_values($row)[0];
    }
}
