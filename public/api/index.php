<?php


//INICIO: HEADER
header("Access-Control-Allow-Origin: *"); //Qualquer site pode acessar
header("Content-Type: application/json; charset=UTF-8"); //tipo de retorno
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE"); // tipos de verbos http aceitos
header("Access-Control-Max-Age: 3600"); // Durabilidade Máxima de 1 hora
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // Habilita alguma autorização
// header('Access-Control-Allow-Headers:  X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding'); // Habilita alguma autorização
//FIM: HEADER

require_once("../../vendor/autoload.php");

use App\Controller\GameArticleController;

$controller = null; //Controller que será chamado
$param      = null; // Parametros que podem vir na url (Exemplo: /game/:id)
$data       = getDataRequest(); // Dado que podem vir da requisição (Exemplo: formulários)
$method     = $_SERVER["REQUEST_METHOD"]; //GET, POST, PUT, PATCH e DELETE
$urlBase    = "localhost/blog-game/api/";
$uri        = getUri($urlBase);

$paramsUri = explode("/", $uri);
$paramsUri = array_values(array_filter($paramsUri)); //retiro valores em branco e pego apenas os values

if (isset($paramsUri[0])) $controller = $paramsUri[0];
if (isset($paramsUri[1])) $param = $paramsUri[1];

// var_dump($paramsUri);

echo json_encode([
    "url"   => $urlBase,
    "uri"   => $uri,
    "method" => $method,
    "controller" => $controller,
    "param" => $param,
    "data" => $data
]);


function getDataRequest(): array
{
    $array = null;

    //parse_str tranforma a string em array associativo

    // pega os dados na pela url
    //parse_str($_SERVER['QUERY_STRING'], $array);
    // ou
    // pega os dados por formulário
    parse_str(file_get_contents("php://input"), $array);

    return $array;

    //https://www.php.net/manual/pt_BR/wrappers.php.php
}

function getUri($urlBase): string
{
    $fullURL = "{$_SERVER["SERVER_NAME"]}{$_SERVER["REQUEST_URI"]}";

    $http = ["http://", "https://"];
    $urlBase = str_replace($http, "", $urlBase);

    $uri = str_replace($urlBase, "", $fullURL);

    return $uri;
}
// FIM


// Inicio

$gameArticle = new GameArticleController();
switch ($method) {
    case 'GET':
        if ($controller != null && $param == null) {
            echo $gameArticle->readAll();
        } else if ($controller != null && $param != null) {
            echo $gameArticle->readByID($param);
        } else {
            echo json_encode(['message' => "invalido"]);
        }
        break;
    case 'POST':
        if ($controller == "game" && $param == null) {
            echo $gameArticle->create($data);
        } else {
            echo json_encode(['message' => "invalido"]);
        }
        break;
    case 'PUT':
    case 'PATCH':
        if ($controller != null && $param != null) {
            echo $gameArticle->update($param, $data);
        } else {
            echo json_encode(['message' => "invalido"]);
        }
        break;
    case 'DELETE':
        if ($controller != null && $param != null) {
            echo $gameArticle->delete($param);
        } else {
            echo json_encode(['message' => "invalido"]);
        }
        break;

    default:
        echo json_encode(['message' => "Requisição invalido"]);
        break;
}
