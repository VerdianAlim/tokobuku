<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["akun"])) {
	echo "<script> alert('Anda belum login');</script>";
	echo "<script> location ='login.php';</script>";
}
?>

<?php include 'header.php'; ?>
<main class="main">

	<div class="page-title dark-background" data-aos="fade" style="background-image: url(home/assets/img/bg1.jpg);">
		<div class="container">
			<h1>Checkout</h1>
			<nav class="breadcrumbs">
				<ol>
					<li><a href="index.php">Home</a></li>
					<li class="current">Checkout</li>
				</ol>
			</nav>
		</div>
	</div>

	<section id="team" class="team section">
		<div class="container">
			<div class="row gy-4">
				<table class="table">
					<thead class="bg-danger text-white">
						<tr class="text-center">
							<th>No</th>
							<th>Buku</th>
							<th>Harga</th>
							<th>Jumlah Beli</th>
							<th>SubHarga</th>
						</tr>
					</thead>
					<tbody>
						<?php $nomor = 1; ?>
						<?php $totalbelanja = 0; ?>
						<?php foreach ($_SESSION["keranjang"] as $idbuku => $jumlah) : ?>
							<?php
							$ambil = $koneksi->query("SELECT * FROM buku 
					WHERE idbuku='$idbuku'");
							$pecah = $ambil->fetch_assoc();
							$totalharga = $pecah["hargabuku"] * $jumlah;
							?>
							<tr class="text-center">
								<td><?php echo $nomor; ?></td>
								<td><?php echo $pecah['namabuku']; ?></td>
								<td>Rp <?php echo number_format($pecah['hargabuku']); ?></td>
								<td><?php echo $jumlah; ?></td>
								<td>Rp <?php echo number_format($totalharga); ?></td>
							</tr>
							<?php $nomor++; ?>
							<?php $totalbelanja += $totalharga; ?>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
<div style="padding-top: 100px;"></div>
		<div class="container">
			<div class="row gy-4">
				<form method="post">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="mb-2">Nama Pelanggan</label>
								<input type="text" readonly value="<?php echo $_SESSION["akun"]['nama'] ?>" class="form-control mb-2">
							</div>
							<div class="form-group">
								<label class="mb-2">No. Handphone Pelanggan</label>
								<input type="text" readonly value="<?php echo $_SESSION["akun"]['telepon'] ?>" class="form-control mb-2">
							</div>
							<div class="form-group">
								<label class="mb-2">Alamat Lengkap Pengiriman</label>
								<textarea class="form-control mb-2" name="alamatpengiriman" placeholder="Masukkan Alamat"></textarea>
							</div>
							<div class="form-group">
								<label class="mb-2">Kota Pengiriman</label>
								<select name="kota" class="form-control mb-2" required id="Sone" onchange="check()">
									<option value="">Pilih Kota</option>
									<option value="Semarang">Semarang</option>
									<option value="Palembang">Palembang</option>
									<option value="Jakarta">Jakarta</option>
									<option value="Bandung">Bandung</option>
									<option value="Surabaya">Surabaya</option>
									<option value="Yogyakarta">Yogyakarta</option>
									<option value="Bali">Bali</option>
									<option value="Cirebon">Cirebon</option>
									<option value="Medan">Medan</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<input type="hidden" id="dua" name="dua" value="<?php echo $totalbelanja ?>">
							<div class="form-group">
								<label class="mb-2">Ongkir Pengiriman</label>
								<input class="form-control mb-2" name="ongkir" type="number" readonly required id="res">
							</div>
							<div class="form-group">
								<label class="mb-2">Total Belanja + Ongkir</label>
								<input class="form-control mb-2" id="result" required readonly type="number">
							</div>
							<button class="btn btn-danger float-end btn-lg" name="checkout">Checkout</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
</main>
<?php
if (isset($_POST["checkout"])) {
	$notransaksi = '#TP' . date("Ymdhis");
	$id = $_SESSION["akun"]["id"];
	$tanggalbeli = date("Y-m-d");
	$waktu = date("Y-m-d H:i:s");
	$alamatpengiriman = $_POST["alamatpengiriman"];
	$totalbeli = $totalbelanja;
	$ongkir = $_POST["ongkir"];
	$kota = $_POST["kota"];
	$koneksi->query(
		"INSERT INTO pembelian(notransaksi,
				id, tanggalbeli, totalbeli, alamatpengiriman, kota, ongkir, statusbeli, waktu)
				VALUES('$notransaksi','$id', '$tanggalbeli', '$totalbeli', '$alamatpengiriman','$kota','$ongkir', 'Belum Bayar', '$waktu')"
	) or die(mysqli_error($koneksi));
	$idbeli_barusan = $koneksi->insert_id;
	foreach ($_SESSION['keranjang'] as $idbuku => $jumlah) {
		$ambil = $koneksi->query("SELECT*FROM buku WHERE idbuku='$idbuku'");
		$perbuku = $ambil->fetch_assoc();
		$nama = $perbuku['namabuku'];
		$harga = $perbuku['hargabuku'];

		$subharga = $perbuku['hargabuku'] * $jumlah;
		$koneksi->query("INSERT INTO pembelianbuku (idbeli, idbuku, nama, harga, subharga, jumlah)
					VALUES ('$idbeli_barusan','$idbuku', '$nama','$harga','$subharga','$jumlah')") or die(mysqli_error($koneksi));
	}
	unset($_SESSION["keranjang"]);
	echo "<script> alert('Pembelian Sukses');</script>";
	echo "<script> location ='riwayat.php';</script>";
}
?>
<?php
include 'footer.php';
?>

<script>
	function check() {
		var val = document.getElementById('Sone').value;
		if (val == 'Medan') {
			document.getElementById('res').value = "15000";
		} else if (val == 'Semarang') {
			document.getElementById('res').value = "15000";
		} else if (val == 'Aceh') {
			document.getElementById('res').value = "15000";
		} else if (val == 'Palembang') {
			document.getElementById('res').value = "5000";
		} else if (val == 'Jakarta') {
			document.getElementById('res').value = "15000";
		} else if (val == 'Bandung') {
			document.getElementById('res').value = "15000";
		} else if (val == 'Surabaya') {
			document.getElementById('res').value = "15000";
		} else if (val == 'Yogyakarta') {
			document.getElementById('res').value = "25000";
		} else if (val == 'Bali') {
			document.getElementById('res').value = "15000";
		} else if (val == 'Cirebon') {
			document.getElementById('res').value = "10000";
		} else if (val == 'Surabaya') {
			document.getElementById('res').value = "8000";
		} else if (val == 'Tanjung Enim') {
			document.getElementById('Tanjung Enim').value = "25000";
		}
		var num1 = document.getElementById("res").value;
		var num2 = document.getElementById("dua").value;
		result = parseInt(num1) + parseInt(num2);
		document.getElementById("result").value = result;

	}
</script>