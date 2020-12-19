<?php

namespace App\Controller;

use App\Entity\GameArticle;
use App\Model\GameArticleModel;

class GameArticleController
{
    private $gameArticleModel;

    public function __construct()
    {
        $this->gameArticleModel = new GameArticleModel;
    }

    //POST - cria artigo
    public function create($data = null)
    {
        $game = $this->convertType($data);

        $valid = $this->validate($game);

        if (!$valid['result']) {
            return json_encode(["result" => $valid["message"]]);
        }

        return $this->gameArticleModel->create($game);
    }

    //PUT - altera artigo
    public function update(int $id = 0, $data = null)
    {
        $game = $this->convertType($data);
        $game->id = $id;
        $valid = $this->validate($game, true);

        if (!$valid['result']) {
            return json_encode(["result" => $valid["message"]]);
        }
    }

    public function delete(int $id = 0)
    {
        return json_encode(["name" => "delete"]);
    }

    public function readById(int $id = 0)
    {
        $list = $this->gameArticleModel->readById($id);
        return json_encode(["article" => $list]);
    }


    public function readAll()
    {
        $list = $this->gameArticleModel->readAll();
        return json_encode(["list" => $list]);
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

    private function validate(GameArticle $game, $update = false)
    {
        if ($update && $game->id <= 0)
            return ["result" => false, "message" => "id inválido"];

        if (strlen($game->title) < 5 || strlen($game->title) > 100)
            return ["result" => false, "message" => "titulo inválido"];

        if (strlen($game->description) < 15 || strlen($game->description) > 250)
            return ["result" => false, "message" => "Descrição inválido"];

        if ($game->videoId == "" || strlen($game->videoId) > 20)
            return ["result" => false, "message" => "Video inválido"];

        return ["result" => true, "message" => "Artigo valido"];
    }
}
