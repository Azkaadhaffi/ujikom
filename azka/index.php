<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Login - Aplikasi Laundry</title>
	<link href="css/styles.css" rel="stylesheet" />
	<script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-dark">
	<div id="layoutAuthentication">
		<div id="layoutAuthentication_content">
			<main>
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-5">
							<div class="card shadow-lg border-0 rounded-lg mt-5">
								<div class="card-header">
									<h3 class="text-center font-weight-light my-4">Login Aplikasi Laundry</h3>
								</div>
								<div class="card-body">
									<?php
									$txt_pesan = '';
									$par_pesan = @$_REQUEST['pesan'];
									if ($par_pesan == 'error') {
										$txt_pesan = 'Login Gagal. ada kesalahan di username atau password';
									} elseif ($par_pesan == 'logout') {
										$txt_pesan = 'Anda sudah keluar dari Aplikasi';
									} elseif ($par_pesan == 'forbidden') {
										$txt_pesan = 'Silahkan login terlebih dahulu';
									} else {
										$txt_pesan = FALSE;
									}

									?>

									<?php if (@$txt_pesan) { ?>
										<div class="alert alert-danger"><?php echo $txt_pesan; ?></div>
									<?php } ?>
									<form action="fungsi/login.php" method="POST">
										<div class="form-floating mb-3">
											<input name="username" class="form-control" id="inputUsername" type="text" placeholder="Username" />
											<label for="inputEmail">Username</label>
										</div>
										<div class="form-floating mb-3">
											<input name="password" class="form-control" id="inputPassword" type="password" placeholder="Password" />
											<label for="inputPassword">Password</label>
										</div>

										<div class="d-flex align-items-center justify-content-between mt-4 mb-0">
											<button type="submit" class="btn btn-primary btn-lg w-100">Login</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>
		<div id="layoutAuthentication_footer">
			<footer class="py-4 bg-secondary mt-auto">
				<div class="container-fluid px-4">
					<center>
						<div class="text-dark">Copyright &copy; Aplikasi Laundry 2022</div>
					</center>
				</div>
			</footer>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
	<script src="js/scripts.js"></script>
</body>

</html>