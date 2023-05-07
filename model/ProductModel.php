<?php
class ProductModel
{
    protected $id_product;
    protected $name;
    protected $description;
    protected $shopping_link;
    protected $min_playes;
    protected $max_players;
    protected $length;
    protected $minimum_age;
    protected $type;
    protected $category;
    protected $publisher;
    protected $add_date;
    protected $hiden;
    protected $media_list = array(
        array(
            "url" => "0-notFoundMedia/1.jpg",
            "type" => "notFound"
        )
    );
    protected $AverageScore;

    function __construct()
    {
        //obtengo un array con los parámetros enviados a la función
        $params = func_get_args();
        //saco el número de parámetros que estoy recibiendo
        $num_params = func_num_args();
        //cada constructor de un número dado de parámtros tendrá un nombre de función
        //atendiendo al siguiente modelo __construct1() __construct2()...
        $funcion_constructor = '__construct' . $num_params;
        //compruebo si hay un constructor con ese número de parámetros
        if (method_exists($this, $funcion_constructor)) {
            //si existía esa función, la invoco, reenviando los parámetros que recibí en el constructor original
            call_user_func_array(array($this, $funcion_constructor), $params);
        }
    }
    public function __construct1($propertiesList)
    {
        $this->id_product = $propertiesList[0];
        $this->name = $propertiesList[1];
        $this->description = $propertiesList[2];
        $this->shopping_link = $propertiesList[3];
        $this->min_playes = $propertiesList[4];
        $this->max_players = $propertiesList[5];
        $this->length = $propertiesList[6];
        $this->minimum_age = $propertiesList[7];
        $this->type = $propertiesList[8];
        $this->category = $propertiesList[9];
        $this->publisher = $propertiesList[10];
        $this->add_date = $propertiesList[11];
        $this->hiden = $propertiesList[12];
    }
    public function __construct13($id_product, $name, $description, $shopping_link, $min_playes, $max_players, $length, $minimum_age, $type, $category, $publisher, $add_date, $hiden)
    {
        $this->id_product = $id_product;
        $this->name = $name;
        $this->description = $description;
        $this->shopping_link = $shopping_link;
        $this->min_playes = $min_playes;
        $this->max_players = $max_players;
        $this->length = $length;
        $this->minimum_age = $minimum_age;
        $this->type = $type;
        $this->category = $category;
        $this->publisher = $publisher;
        $this->add_date = $add_date;
        $this->hiden = $hiden;
    }


    public function getId_product()
    {
        return $this->id_product;
    }

    /**
     * @param $id_product
     */
    public function setId_product($id_product)
    {
        $this->id_product = $id_product;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getShopping_link()
    {
        return $this->shopping_link;
    }

    /**
     * @param $shopping_link
     */
    public function setShopping_link($shopping_link)
    {
        $this->shopping_link = $shopping_link;
    }

    public function getMin_playes()
    {
        return $this->min_playes;
    }

    /**
     * @param $min_playes
     */
    public function setMin_playes($min_playes)
    {
        $this->min_playes = $min_playes;
    }

    public function getMax_players()
    {
        return $this->max_players;
    }

    /**
     * @param $max_players
     */
    public function setMax_players($max_players)
    {
        $this->max_players = $max_players;
    }

    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    public function getMinimum_age()
    {
        return $this->minimum_age;
    }

    /**
     * @param $minimum_age
     */
    public function setMinimum_age($minimum_age)
    {
        $this->minimum_age = $minimum_age;
    }

    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param $publisher
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
    }

    public function getAdd_date()
    {
        return $this->add_date;
    }

    /**
     * @param $add_date
     */
    public function setAdd_date($add_date)
    {
        $this->add_date = $add_date;
    }

    public function getHiden()
    {
        return $this->hiden;
    }

    /**
     * @param $hiden
     */
    public function setHiden($hiden)
    {
        $this->hiden = $hiden;
    }

    public function getMedia_list()
    {
        return $this->media_list;
    }

    /**
     * @param $media_list
     */
    public function setMedia_url($media_url)
    {
        array_push($this->media_list, $media_url);
    }

    /**
     * @param $media_list
     */
    public function setMedia_list($media_list)
    {
        $this->media_list = $media_list;
    }
    public function getAverageScore()
    {
        return $this->AverageScore;
    }

    /**
     * @param $AverageScore
     */
    public function setAverageScore($AverageScore)
    {
        $this->AverageScore = $AverageScore;
    }
    /**
     * @return string
     */
    public function __toString()
    {
        $medias = "";
        for ($i = 0; $i < count($this->media_list); $i++) {
            if ($i == 0) {
                $medias = $this->media_list[$i];
            } elseif ($i == count($this->media_list) - 1) {
                $medias = $medias . ", " . $this->media_list[$i] . ".";
            } else {
                $medias = $medias . ", " . $this->media_list[$i];
            }
        }
        return "Id_product: {$this->id_product}, Name: {$this->name}, Description: {$this->description}, Shopping_link: {$this->shopping_link}, Min_playes: {$this->min_playes}, Max_players: {$this->max_players}, Length: {$this->length}, Minimum_age: {$this->minimum_age}, Type: {$this->type}, Category: {$this->category}, Publisher: {$this->publisher}, Add_date: {$this->add_date}, Hiden: {$this->hiden}" . $medias;
    }
}
