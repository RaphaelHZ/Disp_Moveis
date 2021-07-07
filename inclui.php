<?php
$servidor="localhost;port=3306";
$banco="lista";
$usuario="root";
$senha="";
$strcon="mysql:host=".$servidor.";dbname=".$banco.";charset=utf8";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Accept, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try{
    if ($_SERVER['REQUEST_METHOD'] == "POST" ) {

        $aux = file_get_contents('php://input');
        $valor = json_decode($aux,true);
        if (isset($valor['descricao']) === true) {
            $con =new PDO($strcon,$usuario,$senha);
    
            $sql = "INSERT INTO compras (descricao) VALUES (?)";
            $comando = $con->prepare($sql);
    
            $comando->execute([$valor['descricao']]);
            $codigo=$con->lastInsertId();
    
            http_response_code(201);
            echo('{"codigo":'.$codigo.'}');
        }
    
    } else {
        if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
            http_response_code(200);
        } else {
            http_response_code(406);
            echo('{"message2": "'.$_SERVER['REQUEST_METHOD'].'"}');
        }
    }
} catch (PDOExeption $e) {
    http_response_code(500);
    echo '{"ERROR"}:"' .$e->getMessage().'"}';
}

?>