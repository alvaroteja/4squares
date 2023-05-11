<?php
class AvatarModel
{
    protected $id;
    protected $url;

    public function __construct($id, $url)
    {
        $this->id = $id;
        $this->url = $url;
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }


    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }
}
