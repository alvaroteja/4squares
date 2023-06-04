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

    function getAllFavoritesByUserId($userId)
    {
        try {
            $con = $this->connnection->getConnection();
            $query = "SELECT * FROM favorites WHERE id_user = $userId;";
            $resultset = $con->query($query);

            if ($resultset->num_rows == 0) {
                $con->close();
                return false;
            } else {

                $userPanelFavoriteDtoList = array();
                $scoreService = new ScoreService($this->connnection);
                while ($row = $resultset->fetch_object()) {
                    if (!$this->checkIfProductIsHiddenById($row->id_product)) {
                        $productId = $row->id_product;
                        $img = $this->getProductImgByProducId($productId);;
                        $name = $this->getProductNameByProducId($productId);
                        $averageScore = $scoreService->getAverageScore($productId);


                        $userPanelFavoriteDto = new UserPanelFavoriteDto($img, $name, $averageScore, $productId);

                        array_push($userPanelFavoriteDtoList, $userPanelFavoriteDto);
                    }
                }

                $con->close();
                return $userPanelFavoriteDtoList;
            }
        } catch (Exception $e) {
            return false;
        }
    }
    function getProductNameByProducId($productId)
    {
        try {
            $con = $this->connnection->getConnection();
            $query = "SELECT name FROM products WHERE id = $productId;";
            $resultset = $con->query($query);
            $con->close();

            if ($resultset->num_rows == 0) {
                return false;
            } else {
                $row = $resultset->fetch_object();
                $name = $row->name;
                return $name;
            }
        } catch (Exception $e) {
            return false;
        }
    }
    function getProductImgByProducId($productId)
    {
        try {
            $con = $this->connnection->getConnection();
            $query = "SELECT url FROM `product_medias` WHERE id_product = $productId AND type = 'image' LIMIT 1;";

            $resultset = $con->query($query);
            $con->close();

            if ($resultset->num_rows == 0) {
                return "0-notFoundMedia/1.jpg";
            } else {
                $row = $resultset->fetch_object();
                $img = $row->url;
                return $img;
            }
        } catch (Exception $e) {
            return "0-notFoundMedia/1.jpg";;
        }
    }
    function checkIfProductIsHiddenById($idProduct)
    {
        try {
            $con = $this->connnection->getConnection();
            $query = "SELECT hidden FROM `products` WHERE id = $idProduct;";
            $resultset = $con->query($query);
            $con->close();

            if ($resultset->num_rows == 0) {
                return true;
            } else {
                $row = $resultset->fetch_object();
                $hidden = $row->hidden;
                return $hidden;
            }
        } catch (Exception $e) {
            return true;;
        }
    }
}
