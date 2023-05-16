<?php

class ScoreService
{
    protected $connnection;

    public function __construct($connnection)
    {
        $this->connnection = $connnection;
    }

    function getAverageScore($id_product)
    {
        $scoreList = $this->getScoreList($id_product);
        if ($scoreList) {
            $average = array_sum($scoreList) / count($scoreList);
        } else {
            $average = false;
        }
        return round($average, 1);
    }

    function getScoreList($id_product)
    {
        $scoreList = array();

        $con = $this->connnection->getConnection();

        $query = "SELECT score FROM `scores` WHERE id_product = $id_product";
        $resultset = $con->query($query);

        if ($resultset->num_rows == 0) {
            //mysqli_close($con);
            $con->close();
            return false;
        } else {
            while ($row = mysqli_fetch_array($resultset, MYSQLI_NUM)) {
                array_push($scoreList, $row[0]);
            }
            //mysqli_close($con);
            $con->close();
        }
        return $scoreList;
    }
    function insertScore($id_product, $id_user, $score)
    {
        try {
            $con = $this->connnection->getConnection();
            $query = "INSERT INTO `scores` (`id`, `id_product`, `id_user`, `score`) VALUES (NULL, '" . $id_product . "', '" . $id_user . "', '" . $score . "');";
            $resultset = $con->query($query);
            return $resultset;
        } catch (Exception $e) {
            return false;
        }
    }
    function updateScore($id_product, $id_user, $score)
    {
        try {
            $con = $this->connnection->getConnection();
            $query = "UPDATE scores SET score = $score WHERE id_product = $id_product and id_user = $id_user;";
            $resultset = $con->query($query);
            return $resultset;
        } catch (Exception $e) {
            return false;
        }
    }
}
