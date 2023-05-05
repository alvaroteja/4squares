<?php
class ReviewService
{
    protected $connnection;

    public function __construct($connnection)
    {
        $this->connnection = $connnection;
    }

    //retorna una lista de ReviewDto todas las review del producto con el id introducido
    function getAllReviewsById($id_product)
    {
        if (!is_numeric($id_product)) {
            return false;
        }

        $con = $this->connnection->getConnection();

        $query = "SELECT * FROM `reviews` WHERE id_product = $id_product";
        $resultset = $con->query($query);

        if ($resultset->num_rows == 0) {
            $con->close();
            return false;
        } else {

            $reviewDtoList = array();
            while ($row = $resultset->fetch_object()) {

                $nickname = $this->getNickname($row->id_user);
                $avatar = $this->getAvatar($row->id_user);;
                $date = $row->add_date;
                $hidden = $row->hidden;
                $review = $row->review;
                $reviewDto = new ReviewDto($nickname, $avatar, $date, $hidden, $review, $row->id_user, $row->id);

                array_push($reviewDtoList, $reviewDto);
            }

            $con->close();
            return $reviewDtoList;
        }
    }

    function getNickname($id_user)
    {
        if (!is_numeric($id_user)) {
            return false;
        }

        $con = $this->connnection->getConnection();

        $query = "SELECT nickname FROM `users` WHERE id = $id_user";
        $resultset = $con->query($query);
        $row = $resultset->fetch_object();
        $con->close();
        return $row->nickname;
    }

    function getAvatar($id_user)
    {
        if (!is_numeric($id_user)) {
            return false;
        }

        $con = $this->connnection->getConnection();

        $query = "SELECT id_avatar FROM `users` WHERE id = $id_user";
        $resultset = $con->query($query);
        $row = $resultset->fetch_object();
        $id_avatar = $row->id_avatar;

        $query = "SELECT url FROM `avatars` WHERE id = $id_avatar";
        $resultset = $con->query($query);
        $row = $resultset->fetch_object();

        $con->close();
        return $row->url;
    }

    function writeReview($id_product, $id_user, $review)
    {
        $con = $this->connnection->getConnection();

        $query = "INSERT INTO `reviews` (`id`, `id_product`, `id_user`, `review`, `add_date`, `hidden`) VALUES (NULL, '" . $id_product . "', '" . $id_user . "', '" . $review . "', current_timestamp(), '0');";
        $con->query($query);
        $con->close();
    }

    function hasBeenVotedByUserId($currentProductId, $idUser)
    {
        if (!is_numeric($currentProductId) || !is_numeric($idUser)) {
            return false;
        }

        $con = $this->connnection->getConnection();

        $query = "SELECT score FROM `scores` WHERE id_product = $currentProductId AND id_user = $idUser";
        $resultset = $con->query($query);

        if ($resultset->num_rows == 0) {
            $con->close();
            return false;
        } else {
            $row = $resultset->fetch_object();
            $score = $row->score;

            $con->close();
            return $score;
        }
    }

    function deleteReview($id)
    {
        try {
            $con = $this->connnection->getConnection();

            $query = "DELETE FROM reviews WHERE id=$id;";
            $con->query($query);
            $con->close();
        } catch (Exception $e) {
            return false;
        }
    }
    function saveText($texto)
    {
        $texto = "Este es el contenido que quiero guardar en el archivo de texto.";
        $ruta_archivo = "./archivo.txt";

        // Guardar el contenido en el archivo
        file_put_contents($ruta_archivo, $texto);
    }
}
