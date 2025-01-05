<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>Raja Ongkir PRO</title>
</head>

<body>
  <?php
  $subtotal = 1658000;
  $berat = (isset($_POST['berat']) ? $_POST['berat'] : 1000);
  ?>
  <div class="container">
    <h1>Raja Ongkir PRO</h1>
    <div class="row">
      <div class="col-md-8">
        <form action="" method="POST">
          <label for="berat">Berat</label>
          <input type="text" name="berat">
          <button type="submit" class="btn btn-primary">KIRIM</button>
        </form>
      </div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
            <th scope="col">Harga</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>SUBTOTAL Rp. <?= number_format($subtotal, 0, ',', '.') ?></td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
            <td>Berat : <?= number_format($berat, 0, ',', '.') ?> gram</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td colspan="2">Larry the Bird</td>
            <td>@twitter</td>
            <td>Ongkir : <span class="ongkir"></span> </td>
          </tr>
          <tr>
            <th scope="row">4</th>
            <td>Jonathan</td>
            <td>ThornTarjoton</td>
            <td>@fat</td>
            <td>Total Bayar: <span class='totalbayar'></span></td>
          </tr>
        </tbody>
      </table>
    </div>

    <form method="POST">
      <div class="row">
        <!-- propinsi -->
        <div class="col-md-2">
          <div class="form-group">
            <label>Propinsi</label>
            <select id="id_propinsi" class="form-control" name="nama_propinsi">
            </select>
          </div>
        </div>
        <!-- kabupaten/kota -->
        <div class="col-md-3">
          <div class="form-group">
            <label>Kabupaten/Kota</label>
            <select class="form-control" name="nama_kota" id="id_kota">

            </select>
          </div>
        </div>
        <!-- kecamatan -->
        <div class="col-md-2">
          <div class="form-group">
            <label>Kecamatan</label>
            <select class="form-control" name="nama_kecamatan" id="id_kecamatan">
            </select>
          </div>
        </div>
        <!-- ekspedisi -->
        <div class="col-md-2">
          <div class="form-group">
            <label>Expedisi</label>
            <select class="form-control" name="nama_expedisi">
            </select>
          </div>
        </div>
        <!-- paket -->
        <div class="col-md-3">
          <div class="form-group">
            <label>Paket</label>
            <select class="form-control" name="nama_paket">
            </select>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group mt-2">
          <button type="submit" class="btn btn-primary">KIRIM</button>
        </div>
      </div>
    </form>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>Propinsi</label>
          <input class="form-control" type="text" name="propinsi" value="">
          </select>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>ID Propinsi</label>
          <input class="form-control" type="text" name="id_propinsi" value="">
          </select>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>Kota Tujuan</label>
          <input class="form-control" type="text" name="kota" value="">
          </select>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>Type Kota</label>
          <input class="form-control" type="text" name="type" value="">
          </select>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>ID Kota Tujuan</label>
          <input class="form-control" type="text" name="id_kota" value="">
          </select>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>Kecamatan</label>
          <input class="form-control" type="text" name="camat" value="">
          </select>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>ID Kecamatan</label>
          <input class="form-control" type="text" name="id_camat" value="">
          </select>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>Lama Kirim</label>
          <input class="form-control" type="text" name="lamakirim" value="">
          </select>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>Total Bayar</label>
          <input class="form-control" type="text" name="totalbayar" value="">
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>Jenis Paket</label>
          <input class="form-control" type="text" name="jenispaket" value="">
          </select>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>Berat</label>
          <input class="form-control" type="text" name="berat" value="<?= $berat ?>">
          </select>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>Ongkos Kirim</label>
          <input class="form-control" type="text" name="ongkir" value="">
          </select>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <!---------- untuk ambil data  raja ongkos kirim ---------->
  <script>
    //---------- data propinsi ----------//
    $(document).ready(function() {
      $.ajax({
        type: 'post',
        url: 'ongkir_propinsi.php',
        success: function(hasil_propinsi) {
          $("select[name=nama_propinsi]").html(hasil_propinsi);
        }
      });
    });
    //-----X----- data propinsi -----X-----//

    // ---------- data kabupaten kota berdasarkan data propinsi --------- //
    $(document).ready(function() {
      $("#loading").hide();
      $("select[name=nama_propinsi]").change(function() {
        //Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax 
        var id_propinsi = $("select[name=nama_propinsi]").val();
        // console.log("ID PROPINSI " + id_propinsi);
        $.ajax({
          type: 'POST',
          url: 'ongkir_kabupaten.php',
          data: 'prov_id=' + id_propinsi,
          success: function(hasil_kota) {

            //jika data berhasil didapatkan, tampilkan ke dalam option select kabupaten
            $("select[name=nama_kota]").html(hasil_kota);
          }
        });
      });
    });

    // -----X----- data kabupaten kota berdasarkan data propinsi ----X----- //

    // ---------- data kecamatan berdasarkan data kota --------- //
    $(document).ready(function() {
      $("#loading").hide();
      $("select[name=nama_kota]").change(function() {

        //Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax 
        var id_kota = $("select[name=nama_kota]").val();
        // console.log("ID KOTA " + id_kota);
        $.ajax({
          type: 'POST',
          url: 'ongkir_kecamatan.php',
          data: 'kota_id=' + id_kota,
          success: function(hasil_kecamatan) {

            //tampilkan ke dalam option select kecamatan
            $("select[name=nama_kecamatan]").html(hasil_kecamatan);
          }
        });
      });
    });
    // -----X----- data kecamatan berdasarkan data kota ----X----- //

    // --------- ambil data expedisi ---------- //
    $(document).ready(function() {
      $("select[name=nama_kecamatan]").change(function() {
        $.ajax({
          type: 'POST',
          url: 'ongkir_dataexpedisi.php',
          success: function(hasil_expedisi) {
            $("select[name=nama_expedisi]").html(hasil_expedisi);
          }
        });
      });
    });
    // -----X---- ambil data expedisi -----X----- //

    // --------- ambil data paket ongkir ---------- //
    $(document).ready(function() {

      $("select[name=nama_expedisi]").change(function() {
        var id_kecamatan = $("select[name=nama_kecamatan]").val();
        // var kota = $("select[name=nama_kota]").val();
        var expedisi = $("select[name=nama_expedisi]").val();
        var berat = <?= $berat ?>;
        // console.log("ID KECAMATAN " + id_kecamatan);
        $.ajax({
          type: 'post',
          url: 'ongkir_paket.php',
          // data: 'propinsi_id=' + id_propinsi,
          data: {
            'id_kecamatan': id_kecamatan,
            'kurir': expedisi,
            'berat': berat,
            'id_kotaasal': 444 //444=Surabaya, 151 jakarta barat
          },
          success: function(hasil_paket) {
            $("select[name=nama_paket]").html(hasil_paket);

          }
        });
      });
    });
    // -----X---- ambil data paket -----X----- //

    // ----------- menampilkan ongkos kirim ---------- //
    $(document).ready(function() {

      $("select[name=nama_paket]").change(function() {
        //  ---------- mengambil atribut dari input dengan nama name -----
        // ---------- ongkos kirim
        var dataongkir = $("option:selected", "select[name=nama_paket]").attr("ongkir");
        var rupiah_dataongkir = "Rp. " + dataongkir.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        $(".ongkir").html(rupiah_dataongkir);

        // --------- total bayar
        var totalbayar = parseInt(dataongkir) + parseInt(<?= $subtotal ?>);
        var rupiah_totalbayar = "Rp. " + totalbayar.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');;
        $(".totalbayar").html(rupiah_totalbayar);

        var camat = $("option:selected", "select[name=nama_paket]").attr("kecamatan");
        var id_camat = $("option:selected", "select[name=nama_paket]").attr("id_kecamatan");
        var kota = $("option:selected", "select[name=nama_paket]").attr("kota");
        var type = $("option:selected", "select[name=nama_paket]").attr("type");
        var id_kota = $("option:selected", "select[name=nama_paket]").attr("id_kota");
        var propinsi = $("option:selected", "select[name=nama_paket]").attr("propinsi");
        var id_propinsi = $("option:selected", "select[name=nama_paket]").attr("id_propinsi");
        var jenispaket = $("option:selected", "select[name=nama_paket]").attr("jenispaket");
        var lamakirim = $("option:selected", "select[name=nama_paket]").attr("lamakirim");

        // ----- memasukkan form data lewat input untuk dikirim ke database
        $("input[name=ongkir]").val(dataongkir);
        $("input[name=totalbayar]").val(totalbayar);
        $("input[name=camat]").val(camat);
        $("input[name=id_camat]").val(id_camat);
        $("input[name=kota]").val(kota);
        $("input[name=type]").val(type);
        $("input[name=id_kota]").val(id_kota);
        $("input[name=propinsi]").val(propinsi);
        $("input[name=id_propinsi]").val(id_propinsi);
        $("input[name=lamakirim]").val(lamakirim);
        $("input[name=jenispaket]").val(jenispaket);
      });
    });
  </script>
</body>

</html>