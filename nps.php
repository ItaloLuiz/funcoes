<?php 

$numero_total = '100';
$promotores   = '75';
$detratores   = '2';

function porcentagem($valor,$total){
 $calculo = $valor * 100/$total;
 return $calculo;
}

function NPS($total,$promo,$detra){
  $porcento_promo = porcentagem($promo,$total);
  $porcento_detra = porcentagem($detra,$total);
  $nps = $porcento_promo - $porcento_detra;
  return ceil($nps);
}

echo NPS($numero_total,$promotores,$detratores);

//função para calculo o valor do NPS
function Nps(int $promotores, int $detratores, int $neutros, int $votos){  
  $nps = (($promotores - $detratores)/ $votos) * 100;
  $porcento_promotores = ($promotores/$votos)  * 100;
  $porcento_detratores = ($detratores/$votos)  * 100;
  $porcento_neutros    = ($neutros/$votos)     * 100;
  $dados = array(
  	'Respostas'  => $votos, 
  	'Detratores' => round($porcento_detratores,1) .'%',
  	'Neutros'    => round($porcento_neutros,1) . '%',
  	'Promotores' => round($porcento_promotores,1) . '%',
  	'NPS'        => round($nps)
  );
  return $dados;
}

$promotores = 90;
$detratores = 34;
$neutros    = 85;
$votos      = 209;

$nps = Nps($promotores,$detratores,$neutros,$votos);
