<?php
//include("/xampp/htdocs/tfg/4squares/model/ProductModel.php");
//include_once("../model/ProductModel.php");
//include_once("model/ProductModel.php");


// $test = new ProductService();

// $product = $test->getAProduct(11);
//echo ($test->getAProduct("8")->getCategory());
//echo ($test->getAProduct("9")->getPublisher());
//echo ($test->getProductCategory(9));
// echo "<pre>";
// print_r($product);

class ProductService
{
    protected $connnection;

    public function __construct($connnection)
    {
        $this->connnection = $connnection;
    }
    // $lista = getAllProducts();
    // $lista[0]->setMedia_url("foto01.png");
    // $lista[0]->setMedia_url("foto02.png");
    // $lista[0]->setMedia_url("foto03.png");
    // echo ("<pre>");
    // print_r($lista[0]->getMedia_list());
    // print_r(getAllProducts());

    /**
     * Obtiene un objeto producto al pasarle un id de producto.
     * @param integer   $id_product  Id del producto deseado.
     * @return ProductModel|false   Devuelve un obejo ProductModel con todos los atributos actualizados.
     */
    function getAProduct($id_product)
    {
        if (!is_numeric($id_product)) {
            return false;
        }

        $con = $this->connnection->getConnection();

        $query = "SELECT * FROM `products` WHERE id = $id_product";
        $resultset = $con->query($query);
        if ($resultset->num_rows == 0) {
            //mysqli_close($con);
            $con->close();
            return false;
        } else {
            $row = $resultset->fetch_array(MYSQLI_ASSOC);

            $r = array_values($row);
            $product = new ProductModel($r);
            //$product = new ProductModel($r[0], $r[1], $r[2], $r[3], $r[4], $r[5], $r[6], $r[7], $r[8], $r[9], $r[10], $r[11], $r[12]);

            $product->setType($this->getProductType($product->getType()));
            $product->setCategory($this->getProductCategory($product->getCategory()));
            $product->setPublisher($this->getProductPublisher($product->getPublisher()));
            $mediaList = $this->getProductMediaList($product->getId_product());
            if ($mediaList) {
                $product->setMedia_list($mediaList);
            }
            //mysqli_close($con);
            $con->close();
            return $product;
        }
    }

    /**
     * Obtiene todos los productos de la base de datos.
     * @return array   Devuelve un array de obejos ProductModel con todos los atributos actualizados.
     */
    function getAllProducts()
    {
        $productIdList = $this->getAllIdProducts();

        $productsList = array();

        foreach ($productIdList as $id) {
            array_push($productsList, $this->getAProduct($id));
        }
        return $productsList;
    }

    /**
     * Obtiene todos los id de los productos de la base de datos.
     * @return array   Devuelve un array con todos los id de los productos de la base de datos.
     */
    function getAllIdProducts()
    {
        $idList = array();
        $con = $this->connnection->getConnection();
        $query = "SELECT id from products order by add_date ASC";
        $resultset = $con->query($query);

        foreach ($resultset as $result) {
            array_push($idList, $result['id']);
        }
        //mysqli_close($con);
        $con->close();
        return $idList;
    }
    function getAllIdProductsNotHidden()
    {
        $idList = array();
        $con = $this->connnection->getConnection();
        $query = "SELECT id from products where hidden = 0 order by add_date ASC";
        $resultset = $con->query($query);

        foreach ($resultset as $result) {
            array_push($idList, $result['id']);
        }
        //mysqli_close($con);
        $con->close();
        return $idList;
    }

    /**
     * Obtiene el type en string correspondiente a un id_type.
     * @param integer $id_type
     * @return string   Devuelve un string con el typo correspondiente al id_type introducido.
     */
    function getProductType($id_type)
    {
        $connnection = new DBConnection();
        $con = $connnection->getConnection();

        $query = "SELECT type FROM `types` WHERE id = " . $id_type . ";";
        $resultset = $con->query($query);
        $row = $resultset->fetch_array(MYSQLI_ASSOC);

        $r = array_values($row);
        //mysqli_close($con);
        $con->close();
        return $r[0];
    }

    /**
     * Obtiene la categoria en string correspondiente a un id_category.
     * @param integer $id_category
     * @return string   Devuelve un string con la categoria correspondiente al id_category introducido.
     */
    function getProductCategory($id_category)
    {
        $con = $this->connnection->getConnection();

        $query = "SELECT category FROM `categories` WHERE id = " . $id_category . ";";
        $resultset = $con->query($query);
        $row = $resultset->fetch_array(MYSQLI_ASSOC);

        $r = array_values($row);
        //mysqli_close($con);
        $con->close();
        return $r[0];
    }

    /**
     * Obtiene el publisher en string correspondiente a un id_publisher.
     * @param integer $id_category
     * @return string   Devuelve un string con el publisher correspondiente al id_publisher introducido.
     */
    function getProductPublisher($id_publisher)
    {
        $con = $this->connnection->getConnection();

        $query = "SELECT publisher FROM `publishers` WHERE id = " . $id_publisher . ";";
        $resultset = $con->query($query);
        $row = $resultset->fetch_array(MYSQLI_ASSOC);

        $r = array_values($row);
        //mysqli_close($con);
        $con->close();
        return $r[0];
    }

    /**
     * Obtiene una lista de objetos media con las URL de los media del producto y el tipo de media.
     * @param integer $id_product
     * @return array|false   Devuelve un array con las URL de los media del producto y el tipo de media, si no hay medias, devuelve false.
     */
    function getProductMediaList($id_product)
    {
        $con = $this->connnection->getConnection();

        $query = "SELECT `url`,`type` FROM `product_medias` WHERE id_product=" . $id_product . ";";
        $resultset = $con->query($query);
        if ($resultset->num_rows == 0) {
            //mysqli_close($con);
            $con->close();
            return false;
        } else {
            $mediaList = array();
            foreach ($resultset as $result) {
                array_push($mediaList, $result);
            }
            //mysqli_close($con);
            $con->close();
            return $mediaList;
        }
    }

    function switchProductHideState($productId, $value)
    {

        try {
            session_start();
            unset($_SESSION['productsIdList']);
            $value = $value == 0 ? 1 : 0;
            $con = $this->connnection->getConnection();
            $query = "UPDATE products SET hidden = $value WHERE id = $productId;";
            $con->query($query);
            $con->close();
        } catch (Exception $e) {
            return false;
        }
    }
    function deleteProductById($productId)
    {
        try {
            $con = $this->connnection->getConnection();
            $query = "DELETE FROM products WHERE id = $productId;";
            $con->query($query);
            $con->close();
        } catch (Exception $e) {
            return $e;
        }
    }
}
// if ($resultset->num_rows == 0) {
//     return false;
// } else {
// }