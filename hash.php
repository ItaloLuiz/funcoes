<?php

$senha = 'senha1489';
$cost = 10;

//gerar o hash
function GerarHash($senha, $cost)
{
  return  password_hash($senha, PASSWORD_BCRYPT, ["cost" => $cost]);
}
//verificar a senha
function VerificaHash($senha, $hash)
{
  if (password_verify($senha, $hash)) {
    return json_encode(array('status' => '200'));
  } else {
    return json_encode(array('status' => '401'));
  }
}
//conectar ao banco de dados
function ConectaBD($banco = 'banco')
{
  $servidor = 'localhost';
  $usuario  = 'root';
  $senha    = '';

  $con = mysqli_connect($servidor, $usuario, $senha, $banco);

  if (!$con) {
    return json_encode(array('status' => 'erro ao conectar'));
  } else {
    return $con;
  }
}

//verificar hash no banco
/**
 $info = o tipo de informação que você ira pesquisar, exemplo: email
 $tabela = nome da tabela no banco de dados
 $campo = nome do campo que guarda o Hash

 $info  = array(
   'email',
   'email@email.com'
 );
 */

function PegarHashBD(array $info, $tabela, $campo)
{
  $conecta = ConectaBD();
  $sql     = "SELECT $campo FROM $tabela WHERE $info[0] = '{$info[1]}' LIMIT 1";
  $query   = mysqli_query($conecta, $sql);

  if (mysqli_num_rows($query)) {
    $res  = mysqli_fetch_array($query);
    return $res[$campo];
  } else {
    return json_encode(array('status' => 'sem resultados'));
  }
}

$info  = array(
  'apelido',
  'admin'
);

$tabela = 'tbl_prestador';
$campo  = 'chave';

// colocar esse dado como hash
$seleciona = PegarHashBD($info, $tabela, $campo);

print_r($seleciona);
echo '<br>';

// retorna o Hash
echo $hash = GerarHash($senha, $cost);
echo '<br>';
// retorna 401
echo VerificaHash('145', $hash);
echo '<br>';
// retorna 200
echo VerificaHash('senha1489', $hash);