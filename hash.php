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
// retorna o Hash
echo $hash = GerarHash($senha, $cost);
echo '<br>';
// retorna 401
echo VerificaHash('145', $hash);
echo '<br>';
// retorna 200
echo VerificaHash('senha1489', $hash);
