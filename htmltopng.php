<?php 
$data = json_decode(curl_post("http://api.rest7.com/v1/html_to_image.php", "url=http://rest7.com/html_to_image&format=png"));
//do something with object $data

function curl_post($url, $post)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $data = curl_exec($ch);

    curl_close($ch);
    return $data;
}
