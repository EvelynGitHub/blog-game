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

$controller = null; //Controller que será chamado
$param      = null; // Parametros que podem vir na url (Exemplo: /game/:id)
$data       = getDataRequest(); // Dado que podem vir da requisição (Exemplo: formulários)
$method     = $_SERVER["REQUEST_METHOD"]; //GET, POST, PUT, PATCH e DELETE



echo json_encode([
    "method" => $method,
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
