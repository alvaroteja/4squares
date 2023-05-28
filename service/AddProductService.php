<?php
class AddProductService
{
    protected $connnection;
    protected $name;
    protected $buyLink;
    protected $description;
    protected $minPlayers;
    protected $maxPlayers;
    protected $length;
    protected $minAge;
    protected $type;
    protected $category;
    protected $publisher;
    protected $hidden;
    protected $validationList = [
        "name" => "",
        //"buyLink" => "",
        "description" => "",
        "minPlayers" => "",
        "maxPlayers" => "",
        "length" => "",
        "minAge" => "",
        "type" => "",
        "category" => "",
        "publisher" => "",
        "hidden" => ""
    ];
    protected $ElementsDictionary = [
        "name" => "nombre",
        //"buyLink" => "link de compra",
        "description" => "descripción",
        "minPlayers" => "jugadores mínimos",
        "maxPlayers" => "jugadores máximos",
        "length" => "duración",
        "minAge" => "edad mínima",
        "type" => "tipo",
        "category" => "categoría",
        "publisher" => "editorial",
        "hidden" => "oculto"
    ];
    public function __construct($connnection)
    {
        $this->connnection = $connnection;
    }

    public function validateInputs($list)
    {
        $response = [];
        $response = $this->checkIfMissingInputs($list);
        //si todos los campos tienen contenido, emepzamos a validar el contenido
        if (count($response) == 0) {
            // ver que el nombre no existe en la base de datos
            if ($this->checkIfNameExist($list["name"])) $response["name"] = "El nombre del juego ya existe en la base de datos.";

            // ver que los campos numericos son numericos
            if (!$this->checkIfNumber($list["minPlayers"])) $response["minPlayers"] = "El valor de 'jugadores mínimos' no es válido.";
            if (!$this->checkIfNumber($list["maxPlayers"])) $response["maxPlayers"] = "El valor de 'jugadores máximos' no es válido.";
            if (!$this->checkIfNumber($list["length"])) $response["length"] = "El valor de 'duración' no es válido.";
            if (!$this->checkIfNumber($list["minAge"])) $response["minAge"] = "El valor de 'edad mínima' no es válido.";

            // ver que maxPlayers es mayor o igual que minPlayers
            if ($list["minPlayers"] > $list["maxPlayers"]) $response["minPlayers"] = "El mínimo de jugadores no puede ser mayor que el máximo de jugadores.";
            // ver que los selectores tienen campos que existen en la base de datos
            if (!$this->checkIfSelectExist("type", $list["type"])) $response["type"] = "El tipo seleccionado no existe en la base de datos";
            if (!$this->checkIfSelectExist("category", $list["category"])) $response["category"] = "La categoría seleccionada no existe en la base de datos";
            if (!$this->checkIfSelectExist("publisher", $list["publisher"])) $response["publisher"] = "La editorial seleccionada no existe en la base de datos";
        }
        return $response;
    }
    public function checkIfMissingInputs($list)
    {
        $response = [];
        foreach ($this->validationList as $key => $value) {
            if (!array_key_exists($key, $list) || empty($list["$key"]) || $this->checkForEmptyAfterBlancSpaceTrim($list["$key"])) {
                $translation = $this->ElementsDictionary["$key"];
                $response["$key"] = "El campo '$translation' es obligatorio.";
            }
            // else {
            //     $validationList["$key"] = $list["$key"];
            // }
        }
        return $response;
    }

    public function checkForEmptyAfterBlancSpaceTrim($text)
    {
        $text = trim($text);
        if (strlen($text) > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function checkIfNumber($text)
    {
        $number = intval($text);
        if (is_numeric($text) && $number > 0) {
            return true;
        } else {
            return false;
        }
    }

    function checkIfNameExist($name)
    {
        $con = $this->connnection->getConnection();

        $query = "SELECT * FROM `products` WHERE name = '$name'";
        $resultset = $con->query($query);

        if ($resultset->num_rows == 0) {
            $con->close();
            return false;
        } else {
            $con->close();
            return true;
        }
    }

    function checkIfSelectExist($select, $value)
    {
        $con = $this->connnection->getConnection();

        $table = "";
        if ($select == "type") {
            $table = "types";
        } else if ($select == "publisher") {
            $table = "publishers";
        } else if ($select = "category") {
            $table = "categories";
        }

        $query = "SELECT $select FROM `$table` WHERE 1";
        $resultset = $con->query($query);

        if ($resultset->num_rows == 0) {
            $con->close();
            return false;
        } else {
            $valuesList = [];

            while ($row = $resultset->fetch_object()) {
                $t = $row->$select;
                array_push($valuesList, $t);
            }
            $con->close();

            return in_array($value, $valuesList) ? true : false;
        }
    }

    // function getAllTypes()
    // {
    //     $con = $this->connnection->getConnection();


    //     $query = "SELECT type FROM `types` WHERE 1";
    //     $resultset = $con->query($query);

    //     if ($resultset->num_rows == 0) {
    //         $con->close();
    //         return false;
    //     } else {
    //         $typesList = [];

    //         while ($row = $resultset->fetch_object()) {
    //             $t = $row->type;
    //             array_push($typesList, $t);
    //         }
    //         $con->close();

    //         return $typesList;
    //     }
    // }

    // function getAllCategories()
    // {
    //     $con = $this->connnection->getConnection();


    //     $query = "SELECT category FROM `categories` WHERE 1";
    //     $resultset = $con->query($query);

    //     if ($resultset->num_rows == 0) {
    //         $con->close();
    //         return false;
    //     } else {
    //         $categoriesList = [];

    //         while ($row = $resultset->fetch_object()) {
    //             $t = $row->category;
    //             array_push($categoriesList, $t);
    //         }
    //         $con->close();

    //         return $categoriesList;
    //     }
    // }

    // function getAllPublishers()
    // {
    //     $con = $this->connnection->getConnection();


    //     $query = "SELECT publisher FROM `publishers` WHERE 1";
    //     $resultset = $con->query($query);

    //     if ($resultset->num_rows == 0) {
    //         $con->close();
    //         return false;
    //     } else {
    //         $publishersList = [];

    //         while ($row = $resultset->fetch_object()) {
    //             $t = $row->publisher;
    //             array_push($publishersList, $t);
    //         }
    //         $con->close();

    //         return $publishersList;
    //     }
    // }
    function saveImages($files, $folderName, $productId)
    {
        try {

            // Array para almacenar los nombres de las imágenes guardadas
            $imagesNames = array();

            // Ruta donde se guardarán las imágenes en el servidor
            $finalPath = "../img/products/$folderName/";

            //Si la ruta no existe, se crea
            if (!is_dir($finalPath)) {
                mkdir($finalPath, 0777, true);
            }

            // Iterar sobre cada archivo
            foreach ($files['images']['tmp_name'] as $index => $tmpName) {
                // Obtener nombre y extensión del archivo
                $fileName = $files['images']['name'][$index];
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

                // Generar un nombre único para el archivo
                $uniqueName = uniqid() . '.' . $fileExtension;

                // Ruta completa del archivo en el servidor
                $fullPath = $finalPath . $uniqueName;

                // Mover el archivo al destino final en el servidor
                move_uploaded_file($tmpName, $fullPath);

                // Almacenar el nombre del archivo guardado en el array
                $imagesNames[] = $uniqueName;

                //por cada imagen que guardamos en el server, hago una insercion en la base de datos en la tabla product_media
                $this->addImageToDDBB($productId, $fullPath);
            }

            // Preparar la respuesta JSON
            $response = array(
                'success' => true,
                'message' => 'Imágenes guardadas correctamente',
                //'imageNames' => $_POST["name"]
                'imageNames' => $imagesNames
            );
            return $response;
        } catch (Exception $e) {
            return false;
        }
    }
    function addVideoToDDBB($productId, $link)
    {
        try {

            $con = $this->connnection->getConnection();

            $startsWith = "https://youtu.be/";

            if (strpos($link, $startsWith) === 0) {
                $link = "https://www.youtube.com/embed/" . substr($link, strlen($startsWith));
            }

            $query = "INSERT INTO `product_medias` (`id`, `id_product`, `url`, `type`) VALUES (NULL, '$productId', '$link', 'video');";
            $resultset = $con->query($query);
        } catch (Exception $e) {
            return false;
        }
    }
    function addImageToDDBB($productId, $path)
    {

        try {
            $con = $this->connnection->getConnection();
            $path = str_replace("../img/products/", "", $path);
            $query = "INSERT INTO `product_medias` (`id`, `id_product`, `url`, `type`) VALUES (NULL, '$productId', '$path', 'image');";
            $resultset = $con->query($query);
        } catch (Exception $e) {
            return false;
        }
    }

    function saveProductData($productDataList)
    {
        try {

            $con = $this->connnection->getConnection();

            $name = $_POST["name"];
            $description = $_POST["description"];
            $shopping_link = (!isset($_POST["buyLink"]) || empty($_POST["buyLink"]) || $_POST["buyLink"] == "") ? "https://www.amazon.es/s?k=" . $name : $_POST["buyLink"];
            $min_players = $_POST["minPlayers"];
            $max_players = $_POST["maxPlayers"];
            $length = $_POST["length"];
            $minimum_age = $_POST["minAge"];
            $type = $this->getProductTypeId($_POST["type"]);
            $category = $this->getProductCategoryId($_POST["category"]);
            $publisher = $this->getProductPublisherId($_POST["publisher"]);
            $hidden = ($_POST["hidden"] == "yes") ? "1" : "0";

            $query = "INSERT INTO `products` (`id`, `name`, `description`, `shopping_link`, `min_players`, `max_players`, `length`, `minimum_age`, `type`, `category`, `publisher`, `add_date`, `hidden`)
        VALUES (NULL, '$name', '$description', '$shopping_link', '$min_players', '$max_players', '$length', '$minimum_age', '$type', '$category', '$publisher', current_timestamp(), '$hidden');";
            $con->query($query);
            $insertId = $con->insert_id;

            //si se ha enviado un link de video, se guarda en la BBDD
            if (isset($_POST["videoLink"]) && !empty($_POST["videoLink"]) && $_POST["videoLink"] != "") {
                $this->addVideoToDDBB($insertId, $_POST["videoLink"]);
            }
            return $insertId;
        } catch (Exception $e) {
            return false;
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
}
