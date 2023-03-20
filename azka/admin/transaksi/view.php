<?php
if (isset($_GET['hapus'])) {
  include "./fungsi/koneksi.php";
  $id = $_GET["id"];

  $query = "DELETE FROM tb_transaksi WHERE id='$id' ";
  $hasil_query = mysqli_query($koneksi, $query);

  if (!$hasil_query) {
    die("Gagal menghapus data: " . mysqli_errno($koneksi) .
      " - " . mysqli_error($koneksi));
  } else {
    header("location:admin.php?p=transaksi&terhapus");
  }
}

?>
<h1 class="mt-4">Transaksi</h1>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item">Data</li>
  <li class="breadcrumb-item active">View</li>
</ol>
<div class="row">
  <div class="col-lg-12">
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
    <a href="admin.php?p=transaksi&f=form" class="btn btn-success  mb-3">Tambah Data <i class="fas fa-plus"></i></a>
    <form action="" method="POST">
      <div class="input-group mb-3">
        <input name="keyword" type="text" class="form-control" placeholder="Pencarian Data by Nama Outlet, Nama Member, Kode Invoice">
        <button class="btn btn-secondary" type="submit" id="button-addon2">Cari Data</button>
      </div>
    </form>
    <table class="table table-striped table-inverse table-responsive" width="100%">
      <thead class="thead-inverse">
        <tr>
          <th width="3%">No</th>
          <th>Action</th>
          <th>Outlet</th>
          <th>Kode Invoice</th>
          <th>Member</th>
          <th>Tanggal</th>
          <th>Batas Waktu</th>
          <th>Tanggal Bayar</th>
          <th>Biaya Tambahan</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 0;
        include "./fungsi/koneksi.php";

        $keyword = '';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $keyword = @$_POST['keyword'];
          $where_text = ($_SESSION['id_outlet'] == 0) ? 'where' : 'and';
          $where = " " . $where_text . " (a.kode_invoice like '%" . $keyword . "%' or b.nama like '%" . $keyword . "%'  or c.nama like '%" . $keyword . "%')";
        }

        if ($_SESSION['id_outlet'] != 0) {
          $where2 = "where id_outlet = '" . $_SESSION['id_outlet'] . "'";
        }

        $query = "select a.*, b.nama as nama_outlet, c.nama as nama_member from tb_transaksi a 
        left join tb_outlet b on a.id_outlet = b.id 
        left join tb_member c on a.id_member = c.id 
         " . @$where2 . @$where;
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
                <a href="admin.php?p=transaksi&f=form&edit&id=<?php echo $data['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                <a href="admin.php?p=transaksi&hapus&id=<?php echo $data['id']; ?>" onclick="return confirm('Apakah anda yakin?');" class="btn btn-danger btn-sm">Hapus</a>
                <a href="admin.php?p=transaksi&f=quantity&id=<?php echo $data['id']; ?>" class="btn btn-primary btn-sm">Quantity</a>
              </td>
              <td><?php echo $data['nama_outlet']; ?></td>
              <td><?php echo $data['kode_invoice']; ?></td>
              <td><?php echo $data['nama_member']; ?></td>
              <td><?php echo $data['tgl']; ?></td>
              <td><?php echo $data['batas_waktu']; ?></td>
              <td><?php echo $data['tgl_bayar']; ?></td>
              <td>Rp.<?php echo $data['biaya_tambahan']; ?></td>
              <td><?php echo $data['status']; ?></td>
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

    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
      </ul>
    </nav>
  </div>
</div>