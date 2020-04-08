<?php 
//código da notificação
$cod   = '';
$token = '';
$email = '';

function StatusTransacao($resp)
{
 if ($resp == 1) {
  $msg = 'Aguardando pagamento';
 } else if ($resp == 2) {
  $msg = 'Aprovado';
 } else if ($resp == 3) {
  $msg = 'Paga';
 } else if ($resp == 4) {
  $msg = 'Disponível';
 } else if ($resp == 5) {
  $msg = 'Em disputa';
 } else if ($resp == 6) {
  $msg = 'Devolvida';
 } else if ($resp == 7) {
  $msg = 'Cancelada';
 } else {
  $msg = '';
 }
 return $msg;
}

function Consultatransacao($cod, $token, $email)
{
 $notificacao = preg_replace('/[^[:alnum:]-]/', '', $cod);
 $data['token'] = $token;
 $data['email'] = $email;
 $data = http_build_query($data);
 $url = 'https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/' . $notificacao . '?' . $data;

 $url = file_get_contents($url);
 $xml = simplexml_load_string($url);

 $codTransacao    = (string) $xml->code;
 $codReferencia   = (string) $xml->reference;
 $statusTransacao = (string) $xml->status;

 $dados = array(
  'CodTransacao'    => $codTransacao,
  'CodReferencia'   => $codReferencia,
  'StatusTransacao' => $statusTransacao
 );

 return $dados;
}

$consulta = Consultatransacao($cod, $token, $email);

$status = StatusTransacao($consulta['StatusTransacao']);
