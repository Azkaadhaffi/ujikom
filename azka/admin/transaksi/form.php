<?php
include "./fungsi/koneksi.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = @$_POST['id'];
  $id_outlet = arrInput(@$_POST['id_outlet']);
  $kode_invoice = arrInput(@$_POST['kode_invoice']);
  $id_member = arrInput(@$_POST['id_member']);
  $batas_waktu = arrInput(@$_POST['batas_waktu']);
  $tgl_bayar = arrInput(@$_POST['tgl_bayar']);
  $biaya_tambahan = @$_POST['biaya_tambahan'];
  $diskon = @$_POST['diskon'];
  $pajak = @$_POST['pajak'];
  $status = arrInput(@$_POST['status']);
  $dibayar = arrInput(@$_POST['dibayar']);

  if ($id) {
    $query = "UPDATE tb_transaksi set id_outlet = '$id_outlet', kode_invoice = '$kode_invoice', id_member = '$id_member', batas_waktu = '$batas_waktu', tgl_bayar = '$tgl_bayar', biaya_tambahan='$biaya_tambahan', diskon='$diskon', pajak = '$pajak', `status` = '$status', dibayar = '$dibayar' where id = '$id'";
  } else {
    $query = "INSERT INTO tb_transaksi (id_outlet, kode_invoice, id_member, tgl, batas_waktu, tgl_bayar, biaya_tambahan, diskon, pajak, `status`,dibayar) VALUES ('$id_outlet', '$kode_invoice', '$id_member', '" . date("Y-m-d H:i:s") . "', '$batas_waktu " . date("H:i:s") . "','$tgl_bayar " . date("H:i:s") . "','$biaya_tambahan','$diskon','$pajak','$status','$dibayar')";
  }
  $result = mysqli_query($koneksi, $query);
  // periska query apakah ada error
  // echo $query;
  // exit();
  if (!$result) {
    die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
      " - " . mysqli_error($koneksi));
  } else {
    header("location:admin.php?p=transaksi&tersimpan");
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
  $query_edit = "select * from tb_transaksi where id = '" . $id . "'";
  $row_edit = mysqli_query($koneksi, $query_edit);
  $data_edit = mysqli_fetch_array($row_edit);
}
$check_outlet = (isset($_GET['edit'])) ? $data_edit['id_outlet'] : '';
$check_member = (isset($_GET['edit'])) ? $data_edit['id_member'] : '';
$check_status = (isset($_GET['edit'])) ? $data_edit['status'] : '';
$check_dibayar = (isset($_GET['edit'])) ? $data_edit['dibayar'] : '';
?>
<h1 class="mt-4">Transaksi</h1>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item"><a href="admin.php?p=transaksi">Data</a></li>
  <li class="breadcrumb-item active">Form</li>
</ol>
<div class="row">
  <div class="col-lg-12">

    <form action="" method="POST">
      <input type="hidden" name="id" value="<?php echo (isset($_GET['edit'])) ? $data_edit['id'] : ''; ?>">
      <div class="row">
        <div class="col-lg-6">
          <div class="mb-3">
            <label for="kode_invoice" class="form-label">Kode Invoice</label>
            <input name="kode_invoice" type="text" class="form-control" id="kode_invoice" placeholder="Masukan Kode Invoice" value="<?php echo (isset($_GET['edit'])) ? $data_edit['kode_invoice'] : ''; ?>">
          </div>
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
            <label for="id_member" class="form-label">Member</label>
            <select name="id_member" id="id_member" class="form-select" required>
              <option value="">Pilih Member</option>
              <?php
              $q_member = "select * from tb_member";
              $row_member = mysqli_query($koneksi, $q_member);
              while ($data_member = mysqli_fetch_array($row_member)) {
              ?>
                <option <?php echo ($check_member == $data_member['id']) ? 'selected="selected"' : ''; ?> value="<?php echo $data_member['id']; ?>"><?php echo $data_member['nama']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="batas_waktu" class="form-label">Batas Waktu</label>
            <input name="batas_waktu" type="date" class="form-control" id="batas_waktu" placeholder="Masukan batas_waktu" value="<?php echo (isset($_GET['edit'])) ? date("Y-m-d", strtotime($data_edit['batas_waktu'])) : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="tgl_bayar" class="form-label">Tanggal Bayar</label>
            <input name="tgl_bayar" type="date" class="form-control" id="tgl_bayar" placeholder="Masukan tgl_bayar" value="<?php echo (isset($_GET['edit'])) ? date("Y-m-d", strtotime($data_edit['tgl_bayar'])) : ''; ?>">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="mb-3">
            <label for="biaya_tambahan" class="form-label">Biaya Tambahan</label>
            <div class="input-group mb-3">
              <span class="input-group-text">Rp</span>
              <input name="biaya_tambahan" type="number" class="form-control" id="biaya_tambahan" placeholder="Masukan Biaya Tambahan" value="<?php echo (isset($_GET['edit'])) ? $data_edit['biaya_tambahan'] : ''; ?>">
            </div>
          </div>
          <div class="mb-3">
            <label for="diskon" class="form-label">Diskon</label>
            <input name="diskon" type="text" class="form-control" id="diskon" placeholder="Masukan Diskon %" value="<?php echo (isset($_GET['edit'])) ? $data_edit['diskon'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="pajak" class="form-label">Pajak</label>
            <input name="pajak" type="text" class="form-control" id="pajak" placeholder="Masukan Pajak %" value="<?php echo (isset($_GET['edit'])) ? $data_edit['pajak'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
              <option value="">Pilih status</option>
              <option <?php echo ($check_status == 'baru') ? 'selected="selected"' : ''; ?> value="baru">Baru</option>
              <option <?php echo ($check_status == 'proses') ? 'selected="selected"' : ''; ?>value="proses">Proses</option>
              <option <?php echo ($check_status == 'selesai') ? 'selected="selected"' : ''; ?>value="selesai">Selesai</option>
              <option <?php echo ($check_status == 'diambil') ? 'selected="selected"' : ''; ?>value="diambil">Diambil</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Sudah dibayar?</label>
            <select name="dibayar" id="dibayar" class="form-select">
              <option value="">Pilih status</option>
              <option <?php echo ($check_dibayar == 'dibayar') ? 'selected="selected"' : ''; ?> value="dibayar">Dibayar</option>
              <option <?php echo ($check_dibayar == 'belum_dibayar') ? 'selected="selected"' : ''; ?>value="belum_dibayar">Belum Dibayar</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-auto">
        <button type="submit" name="submit" class="btn btn-primary mb-3">Submit</button>
      </div>
    </form>
  </div>
</div>