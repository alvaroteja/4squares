<?php
class editProductService
{
    protected $connnection;

    public function __construct($connnection)
    {
        $this->connnection = $connnection;
    }

    function getProductData($productId)
    {

        $productData = [];

        return $productData;
    }
}
