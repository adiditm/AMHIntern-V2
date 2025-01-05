<?php

//Get Data Provinsi

$id_propinsi = "a3";

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL            => "https://pro.rajaongkir.com/api/province",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING       => "",
  CURLOPT_MAXREDIRS      => 10,
  CURLOPT_TIMEOUT        => 30,
  CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST  => "GET",
  CURLOPT_HTTPHEADER     => array(
    "key: 34160b287ef591e112fefcf85a70abf1"
  ),
));

$response_propinsi = curl_exec($curl);
$err               = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  $array_propinsi = json_decode($response_propinsi, true);
  $data_propinsi = $array_propinsi['rajaongkir']['results'];
  // echo "<pre>";
  // var_dump($data_propinsi);
  // echo "</pre>";
  echo "<option selected=''>-- Pilih Propinsi --</option>";
  foreach ($data_propinsi as $propinsi) {
    $selected = ($propinsi['province_id'] == $id_propinsi ? 'selected' : '');
    echo "<option value='" . $propinsi['province_id'] . "'" . $selected . ">" . $propinsi['province_id'] . " | " . $propinsi['province'] . "</option>";
  };
}
