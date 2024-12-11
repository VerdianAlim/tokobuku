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
    <h1>Riwayat Pembelian</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="index.php">Home</a></li>
        <li class="current">Riwayat Pembelian</li>
      </ol>
    </nav>
  </div>
</div>

<section id="team" class="team section">
		<div class="container section-title" data-aos="fade-up">
			<h2>Riwayat Pembelian</h2>
		</div>
		<div class="container">
			<div class="row gy-4">
				<div class="col-lg-12 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
				<table class="table">
						<thead class="bg-danger text-white">
							<tr class="text-center">
								<th width="10px">No</th>
								<th width="30%x">Daftar</th>
								<th>Tanggal</th>
								<th>Total</th>
								<th>Opsi</th>
								<th>Bukti Pembayaran</th>
							</tr>
						</thead>
						<tbody>
							<?php $nomor = 1;
							$id = $_SESSION["akun"]['id'];
							$ambil = $koneksi->query("SELECT *, pembelian.idbeli as idbelireal FROM pembelian left join pembayaran on pembelian.idbeli = pembayaran.idbeli WHERE pembelian.id='$id' order by pembelian.tanggalbeli desc, pembelian.idbeli desc");
							while ($pecah = $ambil->fetch_assoc()) { ?>
								<tr>
									<td><?php echo $nomor; ?></td>
									<td>
										<ul>
											<?php $ambilbuku = $koneksi->query("SELECT * FROM pembelianbuku join buku on pembelianbuku.idbuku = buku.idbuku where idbeli='$pecah[idbelireal]'");
												while ($buku = $ambilbuku->fetch_assoc()) { ?>
												<li>
													<?= $buku['namabuku'] ?> x <?= $buku['jumlah'] ?>
												</li>
											<?php } ?>
										</ul>
									</td>
									<td><?php echo tanggal($pecah['tanggalbeli']) . '<br>Jam ' . date('H:i', strtotime($pecah['waktu'])) ?></td>
									<td>Rp. <?php echo number_format($pecah["totalbeli"] + $pecah["ongkir"]); ?></td>
									<td>
										<?php if ($pecah['statusbeli'] == "Belum Bayar") {
												$deadline = date('Y-m-d H:i', strtotime($pecah['waktu'] . ' +1 day'));
												$harideadline = date('Y-m-d', strtotime($pecah['waktu'] . ' +1 day'));
												$jamdeadline = date('H:i', strtotime($pecah['waktu'] . ' +1 day'));
												if (date('Y-m-d H:i') >= $deadline) {
													echo 'Waktu pembayaran<br>telah habis';
												} else { ?>
												<a href="pembayaran.php?id=<?php echo $pecah["idbelireal"] ?>" class="btn btn-danger">Upload Bukti<br>Pembayaran Sebelum<br><?= tanggal($harideadline) . ' - Jam ' . $jamdeadline ?></a>
											<?php }
												} elseif ($pecah['statusbeli'] == "Sudah Upload Bukti Pembayaran") { ?>
											<a class="btn btn-danger text-white">Menunggu Konfirmasi Admin</a>
										<?php
											} elseif ($pecah['statusbeli'] == "Pesanan Sedang Di Proses") { ?>
											<a class="btn btn-info text-white">Pesanan Sedang Di Proses</a>
										<?php } elseif ($pecah['statusbeli'] == "Pesanan Di Kirim") { ?>
											<a class="btn btn-primary text-white">Pesanan Anda Sedang Di Kirim, Mohon Di Tungggu</a>
											<?php
													if ($pecah['resipengiriman'] != "") { ?>
												<br><br>
												<p><a target="_blank" href="https://cekresi.com">No Resi : <?= $pecah['resipengiriman'] ?></a></p>
											<?php } ?>
										<?php } elseif ($pecah['statusbeli'] == "Pesanan Telah Sampai ke Pemesan") { ?>
											<a data-bs-toggle="modal" data-bs-target="#selesai<?= $nomor ?>" class="btn btn-success text-white">Konfirmasi Selesai</a>										<?php } elseif ($pecah['statusbeli'] == "Selesai") { ?>
											<a class="btn btn-success text-white">Selesai</a>
										<?php } elseif ($pecah['statusbeli'] == "Pesanan Di Tolak") { ?>
											<a class="btn btn-danger text-white">Pesanan Anda Di Tolak</a>
										<?php } ?>
									</td>
									<td><img width="100px" src="foto/<?= $pecah['bukti'] ?>" alt=""></td>
								</tr>
								<?php $nomor++; ?>
							<?php  } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
$no = 1;
$id = $_SESSION["akun"]['id'];
$ambil = $koneksi->query("SELECT *, pembelian.idbeli as idbelireal FROM pembelian LEFT JOIN pembayaran ON pembelian.idbeli = pembayaran.idbeli WHERE pembelian.id='$id' ORDER BY pembelian.tanggalbeli DESC, pembelian.idbeli DESC");
while ($pecah = $ambil->fetch_assoc()) { ?>
	<div class="modal fade" id="selesai<?= $no ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pesanan Selesai</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="post">
					<div class="modal-body">
						<h5>Apakah anda yakin ingin mengkonfirmasi pesanan telah selesai?</h5>
					</div>
					<div class="modal-footer">
						<input type="hidden" class="form-control" value="<?= $pecah['idbeli'] ?>" name="idbeli">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
						<button type="submit" name="selesai" value="selesai" class="btn btn-danger">Konfirmasi</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
	$no++;
} ?>

<?php
if (isset($_POST["selesai"])) {
	$koneksi->query("UPDATE pembelian SET statusbeli='Selesai'
		WHERE idbeli='$_POST[idbeli]'");
	echo "<script>alert('Pesanan berhasil di konfirmasi selesai')</script>";
	echo "<script>location='riwayat.php';</script>";
}
?>
<div style="padding-top:250px">
	<?php
	include 'footer.php';
	?>