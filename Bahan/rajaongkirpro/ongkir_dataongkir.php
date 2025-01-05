<?php
$curl = curl_init();

curl_setopt_array(
  $curl,
  array(
    CURLOPT_URL            => "https://pro.rajaongkir.com/api/cost",
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING       => "",
    CURLOPT_MAXREDIRS      => 10,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST  => "POST",
    // CURLOPT_POSTFIELDS     => "origin=" . $id_kotaasal . "&destination=" . $id_kecamatantujuan . "&weight=" . $berat . "&courier=" . $kurir . "",
    CURLOPT_POSTFIELDS     => "origin=" . $id_kotaasal . "&originType=city&destination=" . $id_kecamatantujuan . "&destinationType=subdistrict&weight=" . $berat . "&courier=" . $kurir . "",
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


  $data = json_decode($response, true);

  $kurir          = $data['rajaongkir']['results'][0]['name'];
  $kotaasal       = $data['rajaongkir']['origin_details']['city_name'];
  $provinsiasal   = $data['rajaongkir']['origin_details']['province'];
  $kotatujuan     = $data['rajaongkir']['destination_details']['city_name'];
  $provinsitujuan = $data['rajaongkir']['destination_details']['province'];
  $berat          = $data['rajaongkir']['query']['weight'] / 1000;
  $kurir          = ($kurir == "Jalur Nugraha Ekakurir (JNE)" ? "JNE" : ($kurir == "POS Indonesia (POS)" ? "POS" : "TIKI"));

  if ($i == 1) {
    echo "<input type='hidden' name='id_kota' value='$id_kotatujuan'><br />
<input type='hidden' name='kota_tujuan' value='$kotatujuan'><br />
<input type='hidden' name='propinsitujuan' value='$provinsitujuan'>";
    $dt = "<label>Expedisi</label><input value='Ongkos Kirim dari $kotaasal ke $kotatujuan Berat $berat kg' class='form-control' disabled>";
  } else {
    $dt = "";
  }

  foreach ($data['rajaongkir']['results'][0]['costs'] as $value) {
    $layan = $value['service'];
    $dt .= "<tr>";

    foreach ($value['cost'] as $tarif) {
      $trf = $tarif['value'];
      if ($kurir == "JNE" and $layan == "REG") {
        $check = "checked='checked'";
      } else {
        $check = "";
      }

      $dt .= "<td><input name='ongkir' type='radio' value='$kurir|$trf|$layan' $check required /></td>";
      $dt .= "<td align='right'> " . $tarif['value'] . "</td>";
      $dt .= "<td>" . $tarif['etd'] . " D</td>";
    }
    $dt .= "<td>" . $kurir . "</td>";
    $dt .= "<td>" . $value['service'] . "</td>";
    $dt .= "</tr>";
  };
  return ($dt);
}
