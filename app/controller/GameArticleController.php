<?php

namespace App\Controller;

use App\Entity\GameArticle;

class GameArticleController
{

    //POST - cria artigo
    public function create($data = null)
    {
        return json_encode(["name" => "create"]);
    }

    //PUT - altera artigo
    public function update($id = 0, $data = null)
    {
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
}
