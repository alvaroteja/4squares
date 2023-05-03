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

                $reviewDto = new ReviewDto($nickname, $avatar, $date, $hidden, $review);

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

        return $row->url;
    }
}
