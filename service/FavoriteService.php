<?php
class FavoriteService
{
    protected $connnection;

    public function __construct($connnection)
    {
        $this->connnection = $connnection;
    }

    function checkIfFavoriteByUserId($productId, $userId)
    {
        try {
            $con = $this->connnection->getConnection();
            $query = "SELECT * FROM favorites WHERE id_user = $userId and id_product = $productId;";
            $resultset = $con->query($query);
            $con->close();

            if ($resultset->num_rows == 0) {
                return false;
            } else {
                $row = $resultset->fetch_object();
                $favoriteId = $row->id;
                return $favoriteId;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    function switchFavoriteByUserId($productId, $userId)
    {
        try {
            $favoriteId = $this->checkIfFavoriteByUserId($productId, $userId);
            if ($favoriteId) {
                $con = $this->connnection->getConnection();
                $query = "DELETE from favorites WHERE id = $favoriteId;";
                $con->query($query);
                $con->close();
            } else {
                $con = $this->connnection->getConnection();
                $query = "INSERT INTO `favorites` (`id`, `id_product`, `id_user`, `add_date`) VALUES (NULL, '$productId', '$userId', current_timestamp());";
                $con->query($query);
                $con->close();
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
