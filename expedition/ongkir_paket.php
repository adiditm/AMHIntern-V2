<?php

// $id_kotaasal = 444;
// $berat = 1000;
// $id_kotatujuan = 351;
// $kurir = "jne";
$id_kotaasal  = $_POST['id_kotaasal'];
$berat        = $_POST['berat'];
$id_kecamatan = $_POST['id_kecamatan'];
$kota = $_POST['id_kecamatan'];
$kurir        = $_POST['kurir'];

$curl = curl_init();
curl_setopt_array(
  $curl,
  array(
    CURLOPT_URL            => "https://pro.rajaongkir.com/api/cost",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING       => "",
    CURLOPT_MAXREDIRS      => 10,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_CUSTOMREQUEST  => "POST",
    // CURLOPT_POSTFIELDS     => "origin=" . $id_kotaasal . "&destination=" . $id_kotatujuan . "&weight=" . $berat . "&courier=" . $kurir . "",
    CURLOPT_POSTFIELDS => "origin=" . $id_kotaasal . "&originType=city&destination=" . $id_kecamatan . "&destinationType=subdistrict&weight=" . $berat . "&courier=" . $kurir . "",
    CURLOPT_HTTPHEADER     => array(
      "content-type: application/x-www-form-urlencoded",
      "key: 34160b287ef591e112fefcf85a70abf1"
    ),
  )
);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  // echo $response; //untuk ngetes hasil


  $array_paket = json_decode($response, true);
  $data_paket  = $array_paket['rajaongkir']['results'][0]['costs'];

  echo "<option selected=''>-- Pilih Paket " . $kurir . "--</option>";
  foreach ($data_paket as $paket) {
    echo "<option 
    value        = '" . $paket['service'] . "'
    ongkir       = '" . $paket['cost'][0]['value'] . "'
    lamakirim    = '" . $paket['cost'][0]['etd'] . "'
    jenispaket   = '" . $paket['service'] . "'
    kecamatan    = '" . $array_paket['rajaongkir']['destination_details']['subdistrict_name'] . "'
    id_kecamatan = '" . $array_paket['rajaongkir']['destination_details']['subdistrict_id'] . "'
    kota         = '" . $array_paket['rajaongkir']['destination_details']['city'] . "'
    type         = '" . $array_paket['rajaongkir']['destination_details']['type'] . "'
    id_kota      = '" . $array_paket['rajaongkir']['destination_details']['city_id'] . "'
    propinsi     = '" . $array_paket['rajaongkir']['destination_details']['province'] . "'
    id_propinsi  = '" . $array_paket['rajaongkir']['destination_details']['province_id'] . "'
    >" . $paket['service'] . " | " . $paket['cost'][0]['etd'] . " Hari | Rp. " . number_format($paket['cost'][0]['value'], 0, ',', '.') . "</option>";
  };

  //   $kurir          = $data['rajaongkir']['results'][0]['name'];
  //   $kotaasal       = $data['rajaongkir']['origin_details']['city_name'];
  //   $provinsiasal   = $data['rajaongkir']['origin_details']['province'];
  //   $kotatujuan     = $data['rajaongkir']['destination_details']['city_name'];
  //   $id_kotatujuan     = $data['rajaongkir']['destination_details']['city_id'];
  //   $provinsitujuan = $data['rajaongkir']['destination_details']['province'];
  //   $berat          = $berat;
  //   $kurir          = $kurir;
}
