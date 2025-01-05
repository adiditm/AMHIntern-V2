<?php

//Get Data Kecamatan

$kota_id = $_POST['kota_id'];
$id_kecamatan     = "aaaaaaa106";

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL            => "https://pro.rajaongkir.com/api/subdistrict?city=" . $kota_id,
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

$response_kecamatan = curl_exec($curl);
$err               = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  $array_kecamatan = json_decode($response_kecamatan, true);
  $data_kecamatan  = $array_kecamatan['rajaongkir']['results'];

  echo "<option selected=''>-- Pilih " . $kota_id . " Kecamatan--</option>";
  foreach ($data_kecamatan as $kecamatan) {
    $selected = ($kecamatan['subdistrict_id'] == $id_kecamatan ? 'selected' : '');
    echo "<option value='" . $kecamatan['subdistrict_id'] . "' id_kecamatan='" . $kecamatan['city_id'] . "'" . $selected . ">" . $kecamatan['subdistrict_id'] . " | " . $kecamatan['subdistrict_name'] . "</option>";
  };
}
