<?php

namespace App\Entity;

class GameArticle
{
    private $id;
    private $title;
    private $description;
    private $videoId;

    public function __construct($id = 0, $title = '', $description = '', $videoId = '')
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->videoId = $videoId;
    }

    public function __get($attribute)
    {
        return $this->$attribute;
    }

    public function __set($attribute, $value)
    {
        $this->$attribute = $value;
    }
}
