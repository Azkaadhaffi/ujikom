<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
  <div class="sb-sidenav-menu">
    <div class="nav">
      <div class="sb-sidenav-menu-heading">Main Menu</div>
      <a class="nav-link" href="admin.php">
        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
        Dashboard
      </a>
      <a class="nav-link" href="admin.php?p=transaksi">
        <div class="sb-nav-link-icon"><i class="fa-solid fa-money-bill-wave"></i></div>
        Transaksi
      </a>
      <?php if ($_SESSION['role'] == 'admin') { ?>
        <a class="nav-link" href="admin.php?p=member">
          <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
          Member
        </a>
        <a class="nav-link" href="admin.php?p=outlet">
          <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
          Outlet
        </a>
        <a class="nav-link" href="admin.php?p=paket">
          <div class="sb-nav-link-icon"><i class="fas fa-envelope"></i></div>
          Paket
        </a>
        <a class="nav-link" href="admin.php?p=user">
          <div class="sb-nav-link-icon"><i class="fas fa-user-group"></i></div>
          User
        </a>
      <?php } ?>
    </div>
  </div>
  <div class="sb-sidenav-footer">
    <div class="small">Logged in as:</div>
    <b><?php echo $_SESSION['nama']; ?></b>
  </div>
</nav>