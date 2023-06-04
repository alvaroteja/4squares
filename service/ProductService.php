<?php


class ProductService
{
    protected $connnection;

    public function __construct($connnection)
    {
        $this->connnection = $connnection;
    }

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
        $query = "SELECT id from products order by add_date DESC";
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
        $query = "SELECT id from products where hidden = 0 order by add_date DESC";
        $resultset = $con->query($query);

        foreach ($resultset as $result) {
            array_push($idList, $result['id']);
        }
        //mysqli_close($con);
        $con->close();
        return $idList;
    }
    function getIdProductsByFilter($filter)
    {
        $searchInput = (isset($_POST['searchInput'])
            && !empty($_POST['searchInput'])
            && trim($_POST['searchInput']) != "")
            ? " and name like '%" . trim($_POST['searchInput']) . "%' "
            : " ";
        $minPlayersSeachImput = (isset($_POST['minPlayersSeachImput'])
            && !empty($_POST['minPlayersSeachImput'])
            && trim($_POST['minPlayersSeachImput']) != ""
            && is_numeric($_POST['minPlayersSeachImput'])
            && $_POST['minPlayersSeachImput'] > 0)
            ? " and min_players >= " . trim($_POST['minPlayersSeachImput']) . " "
            : " ";
        $maxPlayersSeachImput = (isset($_POST['maxPlayersSeachImput'])
            && !empty($_POST['maxPlayersSeachImput'])
            && trim($_POST['maxPlayersSeachImput']) != ""
            && is_numeric($_POST['maxPlayersSeachImput'])
            && $_POST['maxPlayersSeachImput'] > 0)
            ? " and max_players <= " . trim($_POST['maxPlayersSeachImput']) . " "
            : " ";
        $minLengthSeachImput = (isset($_POST['minLengthSeachImput'])
            && !empty($_POST['minLengthSeachImput'])
            && trim($_POST['minLengthSeachImput']) != ""
            && is_numeric($_POST['minLengthSeachImput'])
            && $_POST['minLengthSeachImput'] > 0)
            ? " and length >= " . trim($_POST['minLengthSeachImput']) . " "
            : " ";
        $maxLengthSeachImput = (isset($_POST['maxLengthSeachImput'])
            && !empty($_POST['maxLengthSeachImput'])
            && trim($_POST['maxLengthSeachImput']) != ""
            && is_numeric($_POST['maxLengthSeachImput'])
            && $_POST['maxLengthSeachImput'] > 0)
            ? " and length <= " . trim($_POST['maxLengthSeachImput']) . " "
            : " ";
        $minAgeSeachImput = (isset($_POST['minAgeSeachImput'])
            && !empty($_POST['minAgeSeachImput'])
            && trim($_POST['minAgeSeachImput']) != ""
            && is_numeric($_POST['minAgeSeachImput'])
            && $_POST['minAgeSeachImput'] > 0)
            ? " and minimum_age >= " . trim($_POST['minAgeSeachImput']) . " "
            : " ";
        $typeSeachImput = (isset($_POST['typeSeachImput'])
            && !empty($_POST['typeSeachImput'])
            && trim($_POST['typeSeachImput']) != ""
            && $_POST['typeSeachImput'] > 0)
            ? " and type = " . $this->getProductTypeId($_POST['typeSeachImput']) . " "
            : " ";
        $categorySeachImput = (isset($_POST['categorySeachImput'])
            && !empty($_POST['categorySeachImput'])
            && trim($_POST['categorySeachImput']) != ""
            && $_POST['categorySeachImput'] > 0)
            ? " and category = " . $this->getProductCategoryId($_POST['categorySeachImput']) . " "
            : " ";
        $publisherSeachImput = (isset($_POST['publisherSeachImput'])
            && !empty($_POST['publisherSeachImput'])
            && trim($_POST['publisherSeachImput']) != ""
            && $_POST['publisherSeachImput'] > 0)
            ? " and publisher = " . $this->getProductPublisherId($_POST['publisherSeachImput']) . " "
            : " ";
        $hiddenSeachImput = (isset($_POST['hiddenSeachImput'])
            && !empty($_POST['hiddenSeachImput'])
            && trim($_POST['hiddenSeachImput']) != ""
            && $_POST['hiddenSeachImput'] == "yes")
            ? "and hidden = 1"
            : "and hidden = 0";
        $minScoreSeachImput = (isset($_POST['minScoreSeachImput'])
            && !empty($_POST['minScoreSeachImput'])
            && trim($_POST['minScoreSeachImput']) != ""
            && is_numeric($_POST['minScoreSeachImput'])
            && $_POST['minScoreSeachImput'] > 0)
            ? trim($_POST['minScoreSeachImput'])
            : "0";
        $maxScoreSeachImput = (isset($_POST['maxScoreSeachImput'])
            && !empty($_POST['maxScoreSeachImput'])
            && trim($_POST['maxScoreSeachImput']) != ""
            && is_numeric($_POST['maxScoreSeachImput'])
            && $_POST['maxScoreSeachImput'] > 0)
            ? trim($_POST['maxScoreSeachImput'])
            : "5";
        //saco una lista de los ids de los productos filtrados menos la puntuacion
        $idList = array();
        $con = $this->connnection->getConnection();
        $query = "SELECT id from products where 1 $searchInput $minPlayersSeachImput $maxPlayersSeachImput $minLengthSeachImput $maxLengthSeachImput $minAgeSeachImput $typeSeachImput $categorySeachImput $publisherSeachImput $hiddenSeachImput order by add_date DESC";
        $resultset = $con->query($query);

        foreach ($resultset as $result) {
            array_push($idList, $result['id']);
        }
        //aplico un filtro con la puntuacion
        $finalIdList = [];
        $scoreService = new ScoreService($this->connnection);
        foreach ($idList as $id) {
            $averageScore = $scoreService->getAverageScore($id);
            if ($averageScore >= $minScoreSeachImput and $averageScore <= $maxScoreSeachImput) {
                array_push($finalIdList, $id);
            }
        }

        $con->close();

        return $finalIdList;
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

        $query = "SELECT type FROM `types` WHERE id = $id_type;";
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

    function getProductImagesList($id_product)
    {
        $con = $this->connnection->getConnection();

        $query = "SELECT `url` FROM `product_medias` WHERE id_product=" . $id_product . " and type ='image';";
        $resultset = $con->query($query);
        if ($resultset->num_rows == 0) {
            $con->close();
            return false;
        } else {
            $imagesList = array();
            foreach ($resultset as $result) {
                array_push($imagesList, $result['url']);
            }
            $con->close();
            return $imagesList;
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

    function getAllTypes()
    {
        $con = $this->connnection->getConnection();


        $query = "SELECT type FROM `types` WHERE 1";
        $resultset = $con->query($query);

        if ($resultset->num_rows == 0) {
            $con->close();
            return false;
        } else {
            $typesList = [];

            while ($row = $resultset->fetch_object()) {
                $t = $row->type;
                array_push($typesList, $t);
            }
            $con->close();

            return $typesList;
        }
    }
    function getProductTypeId($type)
    {
        $con = $this->connnection->getConnection();

        $query = "SELECT id FROM `types` WHERE type = '$type';";
        $resultset = $con->query($query);
        $row = $resultset->fetch_array(MYSQLI_ASSOC);

        $r = array_values($row);
        $con->close();
        return $r[0];
    }
    function getAllCategories()
    {
        $con = $this->connnection->getConnection();


        $query = "SELECT category FROM `categories` WHERE 1";
        $resultset = $con->query($query);

        if ($resultset->num_rows == 0) {
            $con->close();
            return false;
        } else {
            $categoriesList = [];

            while ($row = $resultset->fetch_object()) {
                $t = $row->category;
                array_push($categoriesList, $t);
            }
            $con->close();

            return $categoriesList;
        }
    }
    function getProductCategoryId($category)
    {
        $con = $this->connnection->getConnection();

        $query = "SELECT id FROM `categories` WHERE category = '$category';";
        $resultset = $con->query($query);
        $row = $resultset->fetch_array(MYSQLI_ASSOC);

        $r = array_values($row);
        $con->close();
        return $r[0];
    }

    function getAllPublishers()
    {
        $con = $this->connnection->getConnection();


        $query = "SELECT publisher FROM `publishers` WHERE 1";
        $resultset = $con->query($query);

        if ($resultset->num_rows == 0) {
            $con->close();
            return false;
        } else {
            $publishersList = [];

            while ($row = $resultset->fetch_object()) {
                $t = $row->publisher;
                array_push($publishersList, $t);
            }
            $con->close();

            return $publishersList;
        }
    }

    function getProductPublisherId($publisher)
    {
        $con = $this->connnection->getConnection();

        $query = "SELECT id FROM `publishers` WHERE publisher = '$publisher';";
        $resultset = $con->query($query);
        $row = $resultset->fetch_array(MYSQLI_ASSOC);

        $r = array_values($row);
        $con->close();
        return $r[0];
    }
}

