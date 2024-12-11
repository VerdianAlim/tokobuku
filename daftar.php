<?php
session_start();
include 'koneksi.php';

?>
<?php include 'header.php'; ?>
<main class="main">

	<div class="page-title dark-background" data-aos="fade" style="background-image: url(home/assets/img/bg1.jpg);">
		<div class="container">
			<h1>Daftar</h1>
			<nav class="breadcrumbs">
				<ol>
					<li><a href="index.php">Home</a></li>
					<li class="current">Daftar</li>
				</ol>
			</nav>
		</div>
	</div>

	<section id="team" class="team section">
		<div class="container section-title" data-aos="fade-up">
			<h2>Daftar</h2>
		</div>
		<div class="container">
			<div class="row gy-4">
				<form method="post" class="form-horizontal">
					<div class="form-group">
						<label class="mb-3">Nama</label>
						<input type="text" name="nama" class="form-control mb-3" required>
					</div>
					<div class="form-group">
						<label class="mb-3">Email</label>
						<input type="email" name="email" class="form-control mb-3" required>
					</div>
					<div class="form-group">
						<label class="mb-3">Password</label>
						<input type="text" name="password" class="form-control mb-3" required>
					</div>
					<div class="form-group">
						<label class="mb-3">Alamat</label>
						<textarea class="form-control mb-3" name="alamat" required></textarea>
					</div>
					<div class="form-group">
						<label class="mb-3">Telepon</label>
						<input type="text" name="telepon" class="form-control mb-3">
					</div>
					<div class="form-group ">
						<br>
						<button class="btn btn-primary float-end" name="daftar">Daftar</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</main>
<?php
if (isset($_POST["daftar"])) {
	$nama = $_POST['nama'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$alamat = $_POST['alamat'];
	$telepon = $_POST['telepon'];
	$ambil = $koneksi->query("SELECT*FROM akun 
							WHERE email='$email'");
	$yangcocok = $ambil->num_rows;
	if ($yangcocok == 1) {
		echo "<script>alert('Pendaftaran Gagal, email sudah ada')</script>";
		echo "<script>location='daftar.php';</script>";
	} else {
		$koneksi->query("INSERT INTO akun	(nama, email,  password, alamat, telepon, level)
								VALUES('$nama','$email','$password','$alamat','$telepon','Pelanggan')");
		echo "<script>alert('Pendaftaran Berhasil')</script>";
		echo "<script>location='login.php';</script>";
	}
}
?>
<?php
include 'footer.php';
?>