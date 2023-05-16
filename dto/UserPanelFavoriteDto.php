<?php
class UserPanelFavoriteDto
{
    protected $img;
    protected $name;
    protected $averageScore;
    protected $productId;

    public function __construct($img, $name, $averageScore, $productId)
    {
        $this->img = $img;
        $this->name = $name;
        $this->averageScore = $averageScore;
        $this->productId = $productId;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function setImg($img)
    {
        $this->img = $img;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getAverageScore()
    {
        return $this->averageScore;
    }

    public function setAverageScore($averageScore)
    {
        $this->averageScore = $averageScore;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;
    }
}
