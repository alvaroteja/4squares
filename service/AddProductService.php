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
        "buyLink" => "",
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
        "buyLink" => "link de compra",
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
}
