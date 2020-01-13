<?php
function ProximaSegunda($data)
{
	$dia = date('w', strtotime($data));
	if ($dia == '0') {
		return date('Y-m-d', strtotime("+1 days", strtotime($data)));
	} else if ($dia == '6') {
		return date('Y-m-d', strtotime("+2 days", strtotime($data)));
	} else {
		return $data;
	}
}

echo ProximaSegunda($data);
