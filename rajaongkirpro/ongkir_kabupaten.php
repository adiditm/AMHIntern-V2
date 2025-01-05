<?php

$provinsi_id = $_POST['prov_id'];
$id_kota = "aaaaaaa106";

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL            => "https://pro.rajaongkir.com/api/city?province=" . $provinsi_id,
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

$response_kota = curl_exec($curl);
$err           = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;

  $array_kota = json_decode($response_kota, true);
  // var_dump($array_kota);
  $data_kota = $array_kota['rajaongkir']['results'];


  echo "<option selected=''>-- Pilih " . $provinsi_id  . " Kab/Kota --</option>";
  foreach ($data_kota as $kota) {
    $selected = ($provinsi_id == $id_kota ? 'selected' : '');
    $type = $kota['type'] == "Kabupaten" ? "Kab." : "";
    echo "<option value='" . $kota['city_id'] . "' idkota_tujuan='" . $kota['city_id'] . "'" . $selected . ">"  . $kota['city_id'] . " | " . $type . " " . $kota['city_name'] . "</option>";
  };
}
