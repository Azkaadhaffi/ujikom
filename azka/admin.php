<?php
session_start();
if ($_SESSION['sedang_login']) {
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta name="description" content="" />
		<meta name="author" content="" />
		<title>Dashboard - Aplikasi Laundry</title>
		<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
		<link href="css/styles.css" rel="stylesheet" />
		<script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
	</head>

	<body class="sb-nav-fixed">
		<?php include "layout/navbar_admin.php"; ?>
		<div id="layoutSidenav">
			<div id="layoutSidenav_nav">
				<?php include "layout/sidebar_admin.php"; ?>
			</div>
			<div id="layoutSidenav_content">
				<main>
					<div class="container-fluid px-4">

						<!-- <div class="alert alert-info mt-3">
							<?php //print_r($_SESSION); ?>
						</div> -->
						<?php
						if (isset($_REQUEST['p'])) {
							$p = @$_REQUEST['p'];
							$f = @$_REQUEST['f'];
							switch ($p) {
								case "transaksi":
									$judul = 'Transaksi';
									$folder = "admin/transaksi";
									break;
								case "member":
									$judul = 'Member';
									$folder = "admin/member";
									break;
								case "outlet":
									$judul = 'Outlet';
									$folder = "admin/outlet";
									break;
								case "paket":
									$judul = 'Paket';
									$folder = "admin/paket";
									break;
								case "user":
									$judul = 'User';
									$folder = "admin/user";
									break;
								default:
									$judul = "";
									$folder = "admin";
									$page = "404";
							}

							$page = (isset($f)) ? $f : 'view';

							include "$folder/$page.php";
						} else {
							$judul = "Dashboard";
							include "admin/dashboard.php";
						}
						?>


					</div>
				</main>
				<footer class="py-4 bg-light mt-auto">
					<div class="container-fluid px-4">
						<div class="d-flex align-items-center justify-content-between small">
							<div class="text-muted">Copyright &copy; App Laundry 2022</div>
							<div>
								<a href="#">Privacy Policy</a>
								&middot;
								<a href="#">Terms &amp; Conditions</a>
							</div>
						</div>
					</div>
				</footer>
			</div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
		<script src="js/scripts.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
		<script src="assets/demo/chart-area-demo.js"></script>
		<script src="assets/demo/chart-bar-demo.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
		<script src="js/datatables-simple-demo.js"></script>
	</body>

	</html>
<?php } else {
	header("location:index.php?pesan=forbidden");
} ?>