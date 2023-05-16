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

    function getAllAvatars()
    {
        try {
            $con = $this->connnection->getConnection();
            $query = "SELECT * FROM `avatars`";
            $resultset = $con->query($query);

            if ($resultset->num_rows == 0) {
                $con->close();
                return false;
            } else {

                $avatarList = array();

                while ($row = $resultset->fetch_object()) {
                    $id = $row->id;
                    $url =  $row->url;

                    $avatarModel = new AvatarModel($id, $url);
                    array_push($avatarList, $avatarModel);
                }

                $con->close();
                return $avatarList;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
