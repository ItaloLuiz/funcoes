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
