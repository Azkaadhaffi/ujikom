<?php
include "./fungsi/koneksi.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = @$_POST['id'];
  $id_detail = @$_POST['id_detail'];
  $id_paket = @$_POST['id_paket'];
  $qty = arrInput(@$_POST['qty']);
  $keterangan = arrInput(@$_POST['keterangan']);

  if ($id_detail) {
    $query = "UPDATE tb_detail_transaksi set id_paket = '$id_paket', qty = '$qty', keterangan = '$keterangan' where id = '$id_detail'";
  } else {
    $query = "INSERT INTO tb_detail_transaksi (id_transaksi, id_paket, qty, keterangan) VALUES ('$id', '$id_paket', '$qty', '$keterangan')";
  }
  $result = mysqli_query($koneksi, $query);
  // periska query apakah ada error
  // echo $query;
  // exit();
  if (!$result) {
    die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
      " - " . mysqli_error($koneksi));
  } else {
    header("location:admin.php?p=transaksi&f=quantity&id=" . $id . "&tersimpan");
  }
}


if (isset($_GET['hapus'])) {
  include "./fungsi/koneksi.php";
  $id = $_GET["id"];
  $detail = $_GET["detail"];

  $query = "DELETE FROM tb_detail_transaksi WHERE id='$detail' ";
  $hasil_query = mysqli_query($koneksi, $query);

  if (!$hasil_query) {
    die("Gagal menghapus data: " . mysqli_errno($koneksi) .
      " - " . mysqli_error($koneksi));
  } else {
    header("location:admin.php?p=transaksi&f=quantity&id=" . $id . "&terhapus");
  }
}

function arrInput($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


$id = $_GET['id'];
$query_edit = "select * from tb_transaksi where id = '" . $id . "'";
$row_edit = mysqli_query($koneksi, $query_edit);
$data_edit = mysqli_fetch_array($row_edit);

$check_dibayar = $data_edit['dibayar'];

$check_paket = '';
$id_detail = '';
if (isset($_GET['edit'])) {
  $id_detail = $_GET['detail'];
  $query_detail = "select * from tb_detail_transaksi where id = '" . $id_detail . "'";
  $row_detail = mysqli_query($koneksi, $query_detail);
  $data_detail = mysqli_fetch_array($row_detail);
  $check_paket = $data_detail['id_paket'];
}

?>
<h1 class="mt-4">Transaksi Quantity</h1>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item"><a href="admin.php?p=transaksi">Data</a></li>
  <li class="breadcrumb-item active">Form</li>
</ol>
<div class="row">
  <div class="col-lg-12">
    <table class="table table-sm table-striped table-inverse table-responsive">
      <?php
      $arr = [
        'kode_invoice' => 'Kode Invoice',
        'id_outlet' => 'Outlet',
        'id_member' => 'Member',
        'batas_waktu' => 'Batas Waktu',
        'tgl_bayar' => 'Tanggal Bayar',
        'biaya_tambahan' => 'Biaya Tambahan',
        'diskon' => 'Diskon',
        'pajak' => 'Pajak',
        'status' => 'Status',
        'dibayar' => 'Sudah Dibayar',
      ];

      foreach ($arr as $key => $val) {

        if ($key == 'id_outlet') {
          $q_outlet = "select * from tb_outlet where id = '" . $data_edit['id_outlet'] . "'";
          $row_outlet = mysqli_query($koneksi, $q_outlet);
          $data_outlet = mysqli_fetch_array($row_outlet);
          $row = $data_outlet['nama'];
        } elseif ($key == 'id_member') {
          $q_member = "select * from tb_member where id = '" . $data_edit['id_member'] . "'";
          $row_member = mysqli_query($koneksi, $q_member);
          $data_member = mysqli_fetch_array($row_member);
          $row = $data_member['nama'];
        } elseif ($key == 'batas_waktu') {
          $row = date("Y-m-d", strtotime($data_edit['batas_waktu']));
        } elseif ($key == 'tgl_bayar') {
          $row = date("Y-m-d", strtotime($data_edit['tgl_bayar']));
        } elseif ($key == 'biaya_tambahan') {
          $row = 'Rp.' . $data_edit['biaya_tambahan'];
        } elseif ($key == 'diskon') {
          $row = $data_edit['diskon'] . '%';
        } elseif ($key == 'pajak') {
          $row = $data_edit['pajak'] . '%';
        } elseif ($key == 'dibayar') {
          $row = ($data_edit['pajak'] == 'dibayar') ? 'Dibayar' : 'Belum dibayar';
        } else {
          $row = $data_edit[$key];
        }
      ?>
        <tr>
          <td width="20%"><?php echo $val; ?></td>
          <td width="1%">:</td>
          <td><?php echo $row; ?></td>
        </tr>
      <?php } ?>
    </table>

    <?php if (isset($_GET['tersimpan'])) { ?>
      <div class="alert alert-success" role="alert">
        Data berhasil disimpan
      </div>
    <?php } ?>

    <?php if (isset($_GET['terhapus'])) { ?>
      <div class="alert alert-success" role="alert">
        Data berhasil dihapus
      </div>
    <?php } ?>

    <table class="table table-striped table-bordered table-responsive" width="100%">
      <thead class="thead-inverse">
        <tr>
          <th width="3%">No</th>
          <th width="12%">Action</th>
          <th>Paket</th>
          <th>Quantity</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 0;
        include "./fungsi/koneksi.php";

        $where2 = "where id_transaksi = '" . $_GET['id'] . "'";
        $query = "select a.*, b.nama_paket as nama_paket from tb_detail_transaksi a 
        left join tb_paket b on a.id_paket = b.id 
         " . @$where2;
        // echo $query;
        $row = mysqli_query($koneksi, $query);
        $count = mysqli_num_rows($row);
        if ($count > 0) {
          while ($data = mysqli_fetch_array($row)) {
            $i++;

        ?>
            <tr>
              <td scope="row"><?php echo $i; ?></td>
              <td>
                <a href="admin.php?p=transaksi&f=quantity&edit&id=<?php echo $_GET['id']; ?>&detail=<?php echo $data['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                <a href="admin.php?p=transaksi&f=quantity&hapus&id=<?php echo $_GET['id']; ?>&detail=<?php echo $data['id']; ?>" onclick="return confirm('Apakah anda yakin?');" class="btn btn-danger btn-sm">Hapus</a>
              </td>
              <td><?php echo $data['nama_paket']; ?></td>
              <td><?php echo $data['qty']; ?></td>
              <td><?php echo $data['keterangan']; ?></td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td colspan="10">
              Data tidak ditemukan
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <form action="" method="POST" class="form-floating mt-5">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <input type="hidden" name="id_detail" value="<?php echo $id_detail; ?>">
      <div class="row">
        <div class="col-lg-6">
          <div class="mb-3">
            <div class="form-floating mb-3">
              <select name="id_paket" id="id_paket" class="form-select" required>
                <option value="">Pilih Paket</option>
                <?php
                $q_paket = "select * from tb_paket";
                $row_paket = mysqli_query($koneksi, $q_paket);
                while ($data_paket = mysqli_fetch_array($row_paket)) {
                ?>
                  <option <?php echo ($check_paket == $data_paket['id']) ? 'selected="selected"' : ''; ?> value="<?php echo $data_paket['id']; ?>"><?php echo $data_paket['nama_paket']; ?> - Rp.<?php echo $data_paket['harga']; ?></option>
                <?php } ?>
              </select>
              <label for="paket" class="form-label">Paket</label>
            </div>
          </div>
          <div class="mb-3">
            <div class="form-floating mb-3">
              <input name="qty" type="text" class="form-control" id="qty" placeholder="Masukan qty" value="<?php echo (isset($_GET['edit'])) ? $data_detail['qty'] : ''; ?>">
              <label for="qty" class="form-label">Qty</label>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="mb-3">
            <label for="diskon" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="inputketerangan" placeholder="Keterangan" class="form-control" rows="3" required="required"><?php echo (isset($_GET['edit'])) ? $data_detail['keterangan'] : ''; ?></textarea>
          </div>
        </div>
      </div>
      <div class="col-auto">
        <button type="submit" name="submit" class="btn btn-primary mb-3">Submit</button>
      </div>
    </form>
  </div>
</div>