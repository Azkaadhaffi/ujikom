<?php
include "./fungsi/koneksi.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = @$_POST['id'];
  $nama = arrInput(@$_POST['nama']);
  $alamat = arrInput(@$_POST['alamat']);
  $jenis_kelamin = arrInput(@$_POST['jenis_kelamin']);
  $tlp = arrInput(@$_POST['tlp']);

  if ($id) {
    $query = "UPDATE tb_member set nama = '$nama', alamat = '$alamat', jenis_kelamin = '$jenis_kelamin', tlp = '$tlp' where id = '$id'";
  } else {
    $query = "INSERT INTO tb_member (nama, alamat, jenis_kelamin, tlp) VALUES ('$nama', '$alamat', '$jenis_kelamin', '$tlp')";
  }
  $result = mysqli_query($koneksi, $query);
  // periska query apakah ada error
  // echo $query;
  // exit();
  if (!$result) {
    die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
      " - " . mysqli_error($koneksi));
  } else {
    header("location:admin.php?p=member&tersimpan");
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
  $query_edit = "select * from tb_member where id = '" . $id . "'";
  $row_edit = mysqli_query($koneksi, $query_edit);
  $data_edit = mysqli_fetch_array($row_edit);
}

$check_jenis_kelamin = (isset($_GET['edit'])) ? $data_edit['jenis_kelamin'] : '';
?>
<h1 class="mt-4">Member</h1>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item"><a href="admin.php?p=member">Data</a></li>
  <li class="breadcrumb-item active">Form</li>
</ol>
<div class="row">
  <div class="col-lg-12">

    <form action="" method="POST">
      <input type="hidden" name="id" value="<?php echo (isset($_GET['edit'])) ? $data_edit['id'] : ''; ?>">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama Lengkap</label>
        <input name="nama" type="text" class="form-control" id="nama" placeholder="Masukan Nama Lengkap" value="<?php echo (isset($_GET['edit'])) ? $data_edit['nama'] : ''; ?>">
      </div>
      <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="5" placeholder="Masukan Alamat"><?php echo (isset($_GET['edit'])) ? $data_edit['alamat'] : ''; ?></textarea>
      </div>
      <div class="mb-3">
        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
          <option value="">Pilih Jenis Kelamin</option>
          <option <?php echo ($check_jenis_kelamin == 'L') ? 'selected="selected"' : ''; ?> value="L">L</option>
          <option <?php echo ($check_jenis_kelamin == 'P') ? 'selected="selected"' : ''; ?>value="P">P</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="tlp" class="form-label">Telepon</label>
        <input name="tlp" type="number" class="form-control" id="tlp" placeholder="Masukan No. Telepon" value="<?php echo (isset($_GET['edit'])) ? $data_edit['tlp'] : ''; ?>">
      </div>

      <div class="col-auto">
        <button type="submit" name="submit" class="btn btn-primary mb-3">Submit</button>
      </div>
    </form>
  </div>
</div>