<?php
class reviewDto
{
    protected $nickname;
    protected $avatar;
    protected $date;
    protected $hidden;
    protected $review;
    protected $idUser;
    protected $idReview;
    protected $userMuted;
    public function __construct($nickname, $avatar, $date, $hidden, $review, $idUser, $idReview, $userMuted)
    {
        $this->nickname = $nickname;
        $this->avatar = $avatar;
        $this->date = $date;
        $this->hidden = $hidden;
        $this->review = $review;
        $this->idUser = $idUser;
        $this->idReview = $idReview;
        $this->userMuted = $userMuted;
    }

    public function getnickname()
    {
        return $this->nickname;
    }

    /**
     * @param $nickname
     */
    public function setnickname($nickname)
    {
        $this->nickname = $nickname;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    public function gethidden()
    {
        return $this->hidden;
    }

    /**
     * @param $hidden
     */
    public function sethidden($hidden)
    {
        $this->hidden = $hidden;
    }

    public function getReview()
    {
        return $this->review;
    }

    /**
     * @param $review
     */
    public function setReview($review)
    {
        $this->review = $review;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param $review
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    public function getIdReview()
    {
        return $this->idReview;
    }

    /**
     * @param $review
     */
    public function setIdReview($idReview)
    {
        $this->idReview = $idReview;
    }

    public function getUserMuted()
    {
        return $this->userMuted;
    }

    /**
     * @param $userMuted
     */
    public function setUserMuted($userMuted)
    {
        $this->userMuted = $userMuted;
    }




    /**
     * @return string
     */
    public function __toString()
    {
        return "Nickname: {$this->nickname}, Avatar: {$this->avatar}, Date: {$this->date}, Hidden: {$this->hidden}, Review: {$this->review}, IdUser: {$this->idUser}, IdReview: {$this->idReview}, UserMuted: {$this->userMuted}";
    }
}
