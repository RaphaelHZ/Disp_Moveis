<?php
$servidor="localhost;port=3306";
$banco="lista";
$usuario="root";
$senha="";
$strcon="mysql:host=".$servidor.";dbname=".$banco.";charset=utf8";
$con =new PDO($strcon,$usuario,$senha);

$sql = "SELECT * FROM compras";
$dados=$con->query($sql);

$obj = $dados->fetchAll(PDO::FETCH_ASSOC);
$resultado = json_encode($obj);

header("Content-Type: application/json");
header("Access-Control-Allow-Origin:*");

print_r($resultado)

/*foreach($dados as $seq => $valor ) {
    echo("<p> Item ");
    print_r($valor["codigo"] );
    echo(" : ");
    print_r($valor["descricao"] );
    echo("</p>");
}*/

?>