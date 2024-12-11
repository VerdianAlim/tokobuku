<?php
session_start();
include 'koneksi.php';
?>
<?php include 'header.php'; ?>
<main class="main">

	<div class="page-title dark-background" data-aos="fade" style="background-image: url(home/assets/img/bg1.jpg);">
		<div class="container">
			<h1>Keranjang</h1>
			<nav class="breadcrumbs">
				<ol>
					<li><a href="index.php">Home</a></li>
					<li class="current">Keranjang</li>
				</ol>
			</nav>
		</div>
	</div>

	<section id="about" class="about section">

		<div class="container">

			<div class="row gy-4" data-aos="fade-up" data-aos-delay="100">
				<div class="col-lg-12">
					<table class="table">
						<thead class="bg-danger text-white">
							<tr class="text-center">
								<th>No</th>
								<th>Buku</th>
								<th>Foto Buku</th>
								<th>Harga</th>
								<th>Jumlah Beli</th>
								<th>Total Harga</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php $nomor = 1; ?>
							<?php if (!empty($_SESSION["keranjang"])) { ?>
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
										<td class="image-prod">
											<img src="foto/<?php echo $pecah["fotobuku"]; ?>" width="100px" style="border-radius: 10px;">
										</td>
										<td>Rp <?php echo number_format($pecah['hargabuku']); ?></td>
										<td><?php echo $jumlah; ?></td>
										<td>Rp <?php echo number_format($totalharga); ?></td>
										<td>
											<a href="hapuskeranjang.php?id=<?php echo $idbuku ?>" class="btn btn-danger btn-xs">Hapus</a>
										</td>
									</tr>
									<?php $nomor++; ?>
							<?php endforeach;
							} ?>
						</tbody>
					</table>
				</div>
			</div>
			<br><br>
			<div class="row justify-content-center">
				<a href="index.php" class="btn btn-warning"><i class="fa fa-cart-plus"></i>Lanjutkan Belanja</a>
				&nbsp;<a href="checkout.php" class="btn btn-danger">Checkout</a>
			</div>
			<br><br>
		</div>
	</section>
</main>

<?php
include 'footer.php';
?>