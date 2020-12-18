<?php

namespace App\Controller;

use App\Entity\GameArticle;

class GameArticleController
{

    //POST - cria artigo
    public function create($data = null)
    {
        $game = $this->convertType($data);

        var_dump($game);
        // return json_encode(["name" => "create"]);
    }

    //PUT - altera artigo
    public function update($id = 0, $data = null)
    {
        $game = $this->convertType($data);
        $game->id = $id;

        return json_encode(["name" => "update"]);
    }

    public function delete($id = 0)
    {
        return json_encode(["name" => "delete"]);
    }

    public function readById($id = 0)
    {
        return json_encode(["name" => "readById"]);
    }


    public function readAll()
    {
        return json_encode(["name" => "readAll"]);
    }

    private function convertType($data)
    {
        return new GameArticle(
            0,
            (isset($data['title']) ? $data['title'] : null),
            (isset($data['description']) ? $data['description'] : null),
            (isset($data['videoId']) ? $data['videoId'] : null)
        );
    }
}
