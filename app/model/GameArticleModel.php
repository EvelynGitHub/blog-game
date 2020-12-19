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
        $game->id = $this->getLastId();

        $this->listGameArticle[] = $game;
        $this->save();

        return "OK";
    }

    public function update(GameArticle $game)
    {
        $res = "Not found";
        for ($i = 0; $i < count($this->listGameArticle); $i++) {
            if ($this->listGameArticle[$i]->id == $game->id) {
                $this->listGameArticle[$i] = $game;
                $res = "update ok";
            }
        }

        $this->save();
        return $res;
    }

    public function delete($id)
    {
        $res = "Not found";
        for ($i = 0; $i < count($this->listGameArticle); $i++) {
            if ($this->listGameArticle[$i]->id == $id) {
                unset($this->listGameArticle[$i]);
                $res = "delete ok";
            }
        }

        $this->listGameArticle = array_values(array_filter($this->listGameArticle));
        $this->save();

        return $res;
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

    public function readById($id)
    {

        foreach ($this->listGameArticle as $l) {
            if ($l->id == $id) {
                return [
                    "id" => $l->id,
                    "title" => $l->title,
                    "description" => $l->description,
                    "videoId" => $l->videoId,
                ];
            }
        }
        return [];
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

    private function getLastId()
    {
        $lastId = 0;

        foreach ($this->listGameArticle as $l) {
            if ($l->id > $lastId)
                $lastId = $l->id;
        }

        return ($lastId + 1);
    }
}
