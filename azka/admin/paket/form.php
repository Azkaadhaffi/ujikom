<?php
include "./fungsi/koneksi.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = @$_POST['id'];
  $id_outlet = arrInput(@$_POST['id_outlet']);
  $jenis = arrInput(@$_POST['jenis']);
  $nama_paket = arrInput(@$_POST['nama_paket']);
  $harga = arrInput(@$_POST['harga']);

  if ($id) {
    $query = "UPDATE tb_paket set id_outlet = '$id_outlet', jenis = '$jenis', nama_paket = '$nama_paket', harga = '$harga' where id = '$id'";
  } else {
    $query = "INSERT INTO tb_paket (id_outlet, jenis, nama_paket, harga) VALUES ('$id_outlet', '$jenis', '$nama_paket', '$harga')";
  }
  $result = mysqli_query($koneksi, $query);
  // periska query apakah ada error
  // echo $query;
  // exit();
  if (!$result) {
    die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
      " - " . mysqli_error($koneksi));
  } else {
    header("location:admin.php?p=paket&tersimpan");
  }
}

function arrInput($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if (isset($_GET['edit'])) {
  $id = $_GET['id'];
  $query_edit = "select * from tb_paket where id = '" . $id . "'";
  $row_edit = mysqli_query($koneksi, $query_edit);
  $data_edit = mysqli_fetch_array($row_edit);
}
$check_outlet = (isset($_GET['edit'])) ? $data_edit['id_outlet'] : '';
$check_jenis = (isset($_GET['edit'])) ? $data_edit['jenis'] : '';
?>
<h1 class="mt-4">Paket</h1>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item"><a href="admin.php?p=paket">Data</a></li>
  <li class="breadcrumb-item active">Form</li>
</ol>
<div class="row">
  <div class="col-lg-12">

    <form action="" method="POST">
      <input type="hidden" name="id" value="<?php echo (isset($_GET['edit'])) ? $data_edit['id'] : ''; ?>">
      <div class="mb-3">
        <label for="outlet" class="form-label">Outlet</label>
        <select name="id_outlet" id="id_outlet" class="form-select" required>
          <option value="">Pilih Outlet</option>
          <?php
          $q_outlet = "select * from tb_outlet";
          $row_outlet = mysqli_query($koneksi, $q_outlet);
          while ($data_outlet = mysqli_fetch_array($row_outlet)) {
          ?>
            <option <?php echo ($check_outlet == $data_outlet['id']) ? 'selected="selected"' : ''; ?> value="<?php echo $data_outlet['id']; ?>"><?php echo $data_outlet['nama']; ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="jenis" class="form-label">Jenis</label>
        <select name="jenis" id="jenis" class="form-select">
          <option value="">Pilih Jenis</option>
          <option <?php echo ($check_jenis == 'kiloan') ? 'selected="selected"' : ''; ?> value="kiloan">Kiloan</option>
          <option <?php echo ($check_jenis == 'selimut') ? 'selected="selected"' : ''; ?>value="selimut">Selimut</option>
          <option <?php echo ($check_jenis == 'bed_cover') ? 'selected="selected"' : ''; ?>value="bed_cover">Bed Cover</option>
          <option <?php echo ($check_jenis == 'kaos') ? 'selected="selected"' : ''; ?>value="kaos">Kaos</option>
          <option <?php echo ($check_jenis == 'lainnya') ? 'selected="selected"' : ''; ?>value="lainnya">Lainnya</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="nama_paket" class="form-label">Nama Paket</label>
        <input name="nama_paket" type="text" class="form-control" id="nama_paket" placeholder="Masukan Nama Paket" value="<?php echo (isset($_GET['edit'])) ? $data_edit['nama_paket'] : ''; ?>">
      </div>
      <div class="mb-3">
        <label for="harga" class="form-label">Harga</label>
        <div class="input-group mb-3">
          <span class="input-group-text">Rp</span>
          <input name="harga" type="number" class="form-control" id="harga" placeholder="Masukan Harga" value="<?php echo (isset($_GET['edit'])) ? $data_edit['harga'] : ''; ?>">
        </div>
      </div>
      <div class="col-auto">
        <button type="submit" name="submit" class="btn btn-primary mb-3">Submit</button>
      </div>
    </form>
  </div>
</div>