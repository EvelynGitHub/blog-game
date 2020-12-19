<?php

namespace App\Model;

use App\Entity\GameArticle;

class GameArticleModel
{
    private $fileName;
    private $listGameArticle = [];

    public function __construct()
    {
        $this->fileName = "../database/blog.db";
    }

    public function create(GameArticle $game)
    {
        $this->listGameArticle[] = $game;
        $this->save();

        return "OK";
    }

    private function save()
    {
        $temp = [];

        foreach ($this->listGameArticle as $l) {

            $temp[] = [
                "id" => $l->id,
                "title" => $l->title,
                "description" => $l->description,
                "videoId" => $l->videoId,
            ];

            $json = json_encode($temp);

            $fp = fopen($this->fileName, "w+");

            fwrite($fp, $json);
            fclose($fp);
        }
    }

    private function load()
    {
        # code...
    }
}
