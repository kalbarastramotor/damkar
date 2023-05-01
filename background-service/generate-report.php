<?php

$curl = curl_init();
var_dump($argv);
unset($argv[0]);
$urlString =  join("/",$argv);
echo 'http://localhost:8888/damkar/export-excel-event/'.$urlString;
die();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost:8888/damkar/export-excel-event/'.$urlString,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Cookie: ci_session=a6d51624ec81071ae498ec19559dbb32987d9ad4'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
