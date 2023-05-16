<?php
class UserModel
{
    protected $id_user;
    protected $first_name;
    protected $surename;
    protected $nickname;
    protected $email;
    protected $id_avatar;
    protected $muted;
    protected $credentials;

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
        $this->id_user = $propertiesList[0];
        $this->first_name = $propertiesList[1];
        $this->surename = $propertiesList[2];
        $this->nickname = $propertiesList[3];
        $this->email = $propertiesList[4];
        $this->id_avatar = $propertiesList[5];
        $this->muted = $propertiesList[6];
        $this->credentials = $propertiesList[7];
    }
    public function __construct8($id_user, $first_name, $surename, $nickname, $email, $id_avatar, $muted, $credentials)
    {
        $this->id_user = $id_user;
        $this->first_name = $first_name;
        $this->surename = $surename;
        $this->nickname = $nickname;
        $this->email = $email;
        $this->id_avatar = $id_avatar;
        $this->muted = $muted;
        $this->credentials = $credentials;
    }


    public function getId_user()
    {
        return $this->id_user;
    }

    /**
     * @param $id_user
     */
    public function setId_user($id_user)
    {
        $this->id_user = $id_user;
    }

    public function getFirst_name()
    {
        return $this->first_name;
    }

    /**
     * @param $first_name
     */
    public function setFirst_name($first_name)
    {
        $this->first_name = $first_name;
    }

    public function getSurename()
    {
        return $this->surename;
    }

    /**
     * @param $surename
     */
    public function setSurename($surename)
    {
        $this->surename = $surename;
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getId_avatar()
    {
        return $this->id_avatar;
    }

    /**
     * @param $id_avatar
     */
    public function setId_avatar($id_avatar)
    {
        $this->id_avatar = $id_avatar;
    }

    public function getMuted()
    {
        return $this->muted;
    }

    /**
     * @param $muted
     */
    public function setMuted($muted)
    {
        $this->muted = $muted;
    }

    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * @param $credentials
     */
    public function setCredentials($credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "id_user: {$this->id_user}, first_name: {$this->first_name}, surename: {$this->surename}, nickname: {$this->nickname}, email: {$this->email}, id_avatar: {$this->id_avatar}, muted: {$this->muted}, credentials: {$this->credentials}.";
    }
}
