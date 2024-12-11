<?php
session_start();
include 'koneksi.php';

?>
<?php include 'header.php'; ?>
<main class="main">

	<div class="page-title dark-background" data-aos="fade" style="background-image: url(home/assets/img/bg1.jpg);">
		<div class="container">
			<h1>Login</h1>
			<nav class="breadcrumbs">
				<ol>
					<li><a href="index.php">Home</a></li>
					<li class="current">Login</li>
				</ol>
			</nav>
		</div>
	</div>

	<section id="team" class="team section">
		<div class="container section-title" data-aos="fade-up">
			<h2>Login</h2>
		</div>
		<div class="container">
			<div class="row gy-4">
				<form method="post" class="form-horizontal">
					<div class="form-group">
						<label class="mb-3">Email</label>
						<input type="email" name="email" class="form-control mb-3" required>
					</div>
					<div class="form-group">
						<label class="mb-3">Password</label>
						<input type="password" name="password" class="form-control mb-3" required>
					</div>
					<div class="form-group ">
						<br>
						<button class="btn btn-primary float-end" name="simpan">Daftar</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</main>
<?php
if (isset($_POST["simpan"])) {
	$email = $_POST["email"];
	$password = $_POST["password"];
	$ambil = $koneksi->query("SELECT * FROM akun
		WHERE email='$email' AND password='$password' limit 1");
	$akunyangcocok = $ambil->num_rows;
	if ($akunyangcocok == 1) {
		$akun = $ambil->fetch_assoc();
		if ($akun['level'] == "Pelanggan") {
			$_SESSION["akun"] = $akun;
			echo "<script> alert('Anda sukses login');</script>";
			echo "<script> location ='index.php';</script>";
		} elseif ($akun['level'] == "Admin") {
			$_SESSION['admin'] = $akun;
			echo "<script> alert('Anda sukses login');</script>";
			echo "<script> location ='admin/index.php';</script>";
		}
	} else {
		echo "<script> alert('Anda gagal login, Cek akun anda');</script>";
		echo "<script> location ='login.php';</script>";
	}
}
?>
<?php
include 'footer.php';
?>