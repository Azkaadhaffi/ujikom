<?php
include "./fungsi/koneksi.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = @$_POST['id'];
  $nama = arrInput(@$_POST['nama']);
  $username = arrInput(@$_POST['username']);
  $password = arrInput(@$_POST['password']);
  $outlet = arrInput(@$_POST['outlet']);
  $role = arrInput(@$_POST['role']);

  if ($id) {
    $q_user = "select * from tb_user where id = '$id'";
    $row_user = mysqli_query($koneksi, $q_user);
    $data_user = mysqli_fetch_array($row_user);
    $password = ($password) ? md5($password) : $data_user['password'];
    $query = "UPDATE tb_user set nama = '$nama', username = '$username', password = '$password', id_outlet = '$outlet', role='$role' where id = '$id'";
  } else {
    $query = "INSERT INTO tb_user (nama, username, password, id_outlet,role) VALUES ('$nama', '$username', '" . md5($password) . "', '$outlet','$role')";
  }
  $result = mysqli_query($koneksi, $query);
  // periska query apakah ada error
  // echo $query;
  // exit();
  if (!$result) {
    die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
      " - " . mysqli_error($koneksi));
  } else {
    header("location:admin.php?p=user&tersimpan");
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
  $query_edit = "select * from tb_user where id = '" . $id . "'";
  $row_edit = mysqli_query($koneksi, $query_edit);
  $data_edit = mysqli_fetch_array($row_edit);
}

$check_role = (isset($_GET['edit'])) ? $data_edit['role'] : '';
$check_outlet = (isset($_GET['edit'])) ? $data_edit['id_outlet'] : '';
?>
<h1 class="mt-4">User</h1>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item"><a href="admin.php?p=user">Data</a></li>
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
        <label for="username" class="form-label">Username</label>
        <input name="username" type="text" class="form-control" id="username" placeholder="Username" value="<?php echo (isset($_GET['edit'])) ? $data_edit['username'] : ''; ?>">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input name="password" type="password" class="form-control" id="password" placeholder="password">
      </div>
      <div class="mb-3">
        <label for="outlet" class="form-label">Outlet</label>
        <select name="outlet" id="outlet" class="form-select">
          <option value="0">Pilih Outlet</option>
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
        <label for="outlet" class="form-label">Role</label>
        <select name="role" id="role" class="form-select">
          <option value="">Pilih Role User</option>
          <option <?php echo ($check_role == 'admin') ? 'selected="selected"' : ''; ?> value="admin">Admin</option>
          <option <?php echo ($check_role == 'owner') ? 'selected="selected"' : ''; ?>value="owner">Owner</option>
          <option <?php echo ($check_role == 'kasir') ? 'selected="selected"' : ''; ?>value="kasir">Kasir</option>
        </select>
      </div>
      <div class="col-auto">
        <button type="submit" name="submit" class="btn btn-primary mb-3">Submit</button>
      </div>
    </form>
  </div>
</div>