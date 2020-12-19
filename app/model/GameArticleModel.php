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
        $this->load();
    }

    public function create(GameArticle $game)
    {
        $this->listGameArticle[] = $game;
        $this->save();

        return "OK";
    }

    public function readAll()
    {
        $temp = [];

        foreach ($this->listGameArticle as $l) {
            $temp[] = [
                "id" => $l->id,
                "title" => $l->title,
                "description" => $l->description,
                "videoId" => $l->videoId,
            ];
        }
        return ($temp);
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

            $fp = fopen($this->fileName, "w");

            fwrite($fp, $json);
            fclose($fp);
        }
    }

    private function load()
    {
        if (!file_exists($this->fileName) || filesize($this->fileName) <= 0)
            return [];

        $fp = fopen($this->fileName, "r");
        $blogDB = fread($fp, filesize($this->fileName));
        fclose($fp);

        $temp = json_decode($blogDB);

        foreach ($temp as $l) {

            $this->listGameArticle[] = new GameArticle(
                $l->id,
                $l->title,
                $l->description,
                $l->videoId
            );
        }
    }
}
