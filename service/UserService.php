<?php
class UserService
{
    protected $connnection;

    public function __construct($connnection)
    {
        $this->connnection = $connnection;
    }

    function muteUser($id, $value)
    {
        try {
            $con = $this->connnection->getConnection();
            $query = "UPDATE users SET muted = $value WHERE id = $id;";
            $con->query($query);
            $con->close();
        } catch (Exception $e) {
            return false;
        }
    }

    function deleteUser($userId)
    {
        try {
            $con = $this->connnection->getConnection();
            $query = "DELETE FROM `users` WHERE id = $userId;";
            $con->query($query);
            $con->close();
        } catch (Exception $e) {
            return false;
        }
    }
    function updateAvatar($userId, $avatarId)
    {
        try {
            $con = $this->connnection->getConnection();
            $query = "UPDATE users SET id_avatar = $avatarId WHERE id = $userId;";
            $con->query($query);
            $con->close();
        } catch (Exception $e) {
            return false;
        }
    }
}
