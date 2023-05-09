<?php
class FavoriteModel
{
    protected $id;
    protected $id_product;
    protected $id_user;
    protected $add_date;

    public function __construct1($id, $id_product, $id_user, $add_date)
    {
        $this->id = $id;
        $this->id_product = $id_product;
        $this->id_user = $id_user;
        $this->add_date = $add_date;
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }


    public function getId_product()
    {
        return $this->id_product;
    }

    public function setId_product($id_product)
    {
        $this->id_product = $id_product;
    }

    public function getId_user()
    {
        return $this->id_user;
    }

    public function setId_user($id_user)
    {
        $this->id_user = $id_user;
    }

    public function getAdd_date()
    {
        return $this->add_date;
    }

    public function setAdd_date($add_date)
    {
        $this->add_date = $add_date;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return "id: {$this->id},id_product: {$this->id_product},id_user: {$this->id_user},add_date: {$this->add_date}.";
    }
}
