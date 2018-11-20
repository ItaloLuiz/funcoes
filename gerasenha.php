<?php
function GeraSenha($qtda,$esp = false){
	if($qtda <=3){
		$qtda = 4;
	}
	if($esp == true){
		$carac = '@!#$%*-^~';
	}else{
		$carac = '';
	}
	$str = 'abcdefghijklmnopqrstuvxzyw0123456789ABDEFGHIJKLMNOPQRSTUVXZYW'.$carac;
	$shuffle = str_shuffle($str);
	return substr($shuffle,mt_rand(0,2),$qtda);
}

echo GeraSenha(6,false);
