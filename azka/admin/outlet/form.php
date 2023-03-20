<?php
include "./fungsi/koneksi.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = @$_POST['id'];
  $nama = arrInput(@$_POST['nama']);
  $alamat = arrInput(@$_POST['alamat']);
  $tlp = arrInput(@$_POST['tlp']);

  if ($id) {
    $query = "UPDATE tb_outlet set nama = '$nama', alamat = '$alamat', tlp = '$tlp' where id = '$id'";
  } else {
    $query = "INSERT INTO tb_outlet (nama, alamat, tlp) VALUES ('$nama', '$alamat', '$tlp')";
  }
  $result = mysqli_query($koneksi, $query);
  // periska query apakah ada error
  // echo $query;
  // exit();
  if (!$result) {
    die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
      " - " . mysqli_error($koneksi));
  } else {
    header("location:admin.php?p=outlet&tersimpan");
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
  $query_edit = "select * from tb_outlet where id = '" . $id . "'";
  $row_edit = mysqli_query($koneksi, $query_edit);
  $data_edit = mysqli_fetch_array($row_edit);
}

?>
<h1 class="mt-4">Outlet</h1>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item"><a href="admin.php?p=outlet">Data</a></li>
  <li class="breadcrumb-item active">Form</li>
</ol>
<div class="row">
  <div class="col-lg-12">

    <form action="" method="POST">
      <input type="hidden" name="id" value="<?php echo (isset($_GET['edit'])) ? $data_edit['id'] : ''; ?>">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama Outlet</label>
        <input name="nama" type="text" class="form-control" id="nama" placeholder="Masukan Nama Outlet" value="<?php echo (isset($_GET['edit'])) ? $data_edit['nama'] : ''; ?>">
      </div>
      <div class="mb-3">
        <label for="username" class="form-label">Alamat</label>
        <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="5" placeholder="Masukan Alamat"><?php echo (isset($_GET['edit'])) ? $data_edit['alamat'] : ''; ?></textarea>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Telepon</label>
        <input name="tlp" type="text" class="form-control" id="tlp" placeholder="Masukan No. Telepon" value="<?php echo (isset($_GET['edit'])) ? $data_edit['tlp'] : ''; ?>">
      </div>

      <div class="col-auto">
        <button type="submit" name="submit" class="btn btn-primary mb-3">Submit</button>
      </div>
    </form>
  </div>
</div>