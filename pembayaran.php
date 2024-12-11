<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["akun"])) {
	echo "<script> alert('Anda belum login');</script>";
	echo "<script> location ='login.php';</script>";
	exit();
}
$idpem = $_GET["id"];
$ambil = $koneksi->query("SELECT*FROM pembelian WHERE idbeli='$idpem'");
$detpem = $ambil->fetch_assoc();

$id_beli = $detpem["id"];
$id_login = $_SESSION["akun"]["id"];
if ($id_login !== $id_beli) {
	echo "<script> alert('Gagal');</script>";
	echo "<script> location ='riwayat.php';</script>";
}
$deadline = date('Y-m-d H:i', strtotime($detpem['waktu'] . ' +1 day'));
$harideadline = date('Y-m-d', strtotime($detpem['waktu'] . ' +1 day'));
$jamdeadline = date('H:i', strtotime($detpem['waktu'] . ' +1 day'));
if (date('Y-m-d H:i') >= $deadline) {
	echo "<script> alert('Waktu pembayaran telah habis');</script>";
	echo "<script> location ='riwayat.php';</script>";
}

?>
<?php include 'header.php'; ?>
<main class="main">

	<div class="page-title dark-background" data-aos="fade" style="background-image: url(home/assets/img/bg1.jpg);">
		<div class="container">
			<h1>Pembayaran</h1>
			<nav class="breadcrumbs">
				<ol>
					<li><a href="index.php">Home</a></li>
					<li class="current">Pembayaran</li>
				</ol>
			</nav>
		</div>
	</div>

	<section id="team" class="team section">
		<div class="container mt-4">
			<?php
			$ambil = $koneksi->query("SELECT*FROM pembelian JOIN akun
		ON pembelian.id=akun.id
		WHERE pembelian.idbeli='$_GET[id]'");
			$detail = $ambil->fetch_assoc();
			?>
			<h4 class="text-danger">Upload Bukti Pembayaran Sebelum <?= tanggal($harideadline) . ' - Jam ' . $jamdeadline ?></h4>
			<br>
			<div class="row">
				<!-- Card Informasi Pembelian -->
				<div class="col-md-6 mb-3">
					<div class="card">
						<div class="card-header bg-primary text-white">
							<strong>Informasi Pembelian</strong>
						</div>
						<div class="card-body">
							<p><strong>NO PEMBELIAN:</strong> <?php echo $detail['idbeli']; ?></p>
							<p><strong>Status Pesanan:</strong> <?php echo $detail['statusbeli']; ?></p>
							<p><strong>Total Pembelian:</strong> Rp. <?php echo number_format($detail['totalbeli']); ?></p>
							<p><strong>Ongkir:</strong> Rp. <?php echo number_format($detail['ongkir']); ?></p>
							<p><strong>Total Bayar:</strong> Rp. <?php echo number_format($detail['ongkir'] + $detail['totalbeli']); ?></p>
						</div>
					</div>
				</div>

				<!-- Card Informasi Pelanggan -->
				<div class="col-md-6 mb-3">
					<div class="card">
						<div class="card-header bg-success text-white">
							<strong>Informasi Pelanggan</strong>
						</div>
						<div class="card-body">
							<p><strong>Nama:</strong> <?php echo $detail['nama']; ?></p>
							<p><strong>Telepon:</strong> <?php echo $detail['telepon']; ?></p>
							<p><strong>Email:</strong> <?php echo $detail['email']; ?></p>
							<p><strong>Kota:</strong> <?php echo $detail['kota']; ?></p>
							<p><strong>Alamat Pengiriman:</strong> <?php echo $detail['alamatpengiriman']; ?></p>
						</div>
					</div>
				</div>
			</div>

			<br>
			<table class="table table-bordered">
				<thead class="bg-danger text-white">
					<tr>
						<th>No</th>
						<th>Nama Buku</th>
						<th>Harga</th>
						<th>Jumlah</th>
						<th>Total Harga</th>
					</tr>
				</thead>
				<tbody>
					<?php $nomor = 1; ?>
					<?php $ambil = $koneksi->query("SELECT * FROM pembelianbuku WHERE idbeli='$_GET[id]'"); ?>
					<?php while ($pecah = $ambil->fetch_assoc()) { ?>
						<tr>
							<td><?php echo $nomor; ?></td>
							<td><?php echo $pecah['nama']; ?></td>
							<td>Rp. <?php echo number_format($pecah['harga']); ?></td>
							<td><?php echo $pecah['jumlah']; ?></td>
							<td>Rp. <?php echo number_format($pecah['subharga']); ?></td>
						</tr>
						<?php $nomor++; ?>
					<?php } ?>
				</tbody>
			</table>
			<div class="row justify-content-center mb-5 mt-5">

				<div class="col-md-7">
					<p>Kirim Bukti Pembayaran</p>
					<b>Dana : +62 822-1640-5437 (Toko Buku)</b>
					<br>
					<br>
					<div class="alert alert-success">Total Tagihan Anda : <strong>Rp. <?php echo number_format($detpem["totalbeli"] + $detpem["ongkir"]) ?> <br>(Sudah
							Termasuk biaya pengiriman)</strong></div>

					<form method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label class="mb-2">Nama Rekening</label>
							<input type="text" name="nama" class="form-control mb-2" value="<?= $_SESSION['akun']['nama'] ?>" required>

						</div>
						<div class="form-group">
							<label class="mb-2">Tanggal Transfer</label>
							<input type="date" name="tanggaltransfer" class="form-control mb-2" value="<?= date('Y-m-d') ?>" required>

						</div>
						<div class="form-group">
							<label class="mb-2">Foto Bukti</label>
							<input type="file" name="bukti" class="form-control mb-2" required>
						</div>
						<button class="btn btn-danger float-end" name="kirim">Simpan</button>
					</form>
				</div>
				<div class="col-md-5">
					<img width="100%" src="foto/bayar.jpg">
				</div>
			</div>
		</div>
	</section>
</main>
<?php
if (isset($_POST["kirim"])) {
	$namabukti = $_FILES["bukti"]["name"];
	$lokasibukti = $_FILES["bukti"]["tmp_name"];
	$namafix = date("YmdHis") . $namabukti;
	move_uploaded_file($lokasibukti, "foto/$namafix");

	$nama = $_POST["nama"];
	$tanggaltransfer = $_POST["tanggaltransfer"];
	$tanggal = date("Y-m-d");


	$koneksi->query("INSERT INTO pembayaran(idbeli, nama, tanggaltransfer,tanggal, bukti)
		VALUES ('$idpem','$nama','$tanggaltransfer','$tanggal','$namafix')");

	$koneksi->query("UPDATE pembelian SET statusbeli='Sudah Upload Bukti Pembayaran'
		WHERE idbeli='$idpem'");
	echo "<script> alert('Terima kasih, Pembayaran anda berhasil di uplaod, mohon menunggu konfirmasi admin');</script>";
	echo "<script>location='riwayat.php';</script>";
}
?>
<?php
include 'footer.php';
?>