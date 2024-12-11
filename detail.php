<?php
session_start();
include 'koneksi.php';
?>
<?php
$idbuku = $_GET["id"];
$ambil = $koneksi->query("SELECT*FROM buku WHERE idbuku='$idbuku'");
$detail = $ambil->fetch_assoc();
$kategori = $detail["id_kategori"];
?>
<?php include 'header.php'; ?>
<main class="main">

<div class="page-title dark-background" data-aos="fade" style="background-image: url(home/assets/img/bg1.jpg);">
  <div class="container">
    <h1>Detail Buku</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="index.php">Home</a></li>
        <li class="current">Detail Buku</li>
      </ol>
    </nav>
  </div>
</div>
<section id="about" class="about section">

<div class="container">

  <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">
	<div class="col-lg-5">
	  <img src="foto/<?php echo $detail["fotobuku"]; ?>" class="img-fluid" alt="">
	</div>
	<div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">
	  <div class="content">
	  <h3><?php echo $detail["namabuku"] ?></h3>
				<p class="price"><span>Rp. <?php echo number_format($detail["hargabuku"]); ?></span></p>
				<h6>Deskripsi Buku</h6>
				<p><?php echo $detail["deskripsibuku"]; ?></p>
				<div class="row mt-4">
					<div class="w-100"></div>
					<div class="col-md-12">
						<p style="color: #000;">Sisa Buku : <?php echo number_format($detail["stokbuku"]); ?></p>
					</div>
				</div>
				<form method="post">
					<div class="form-group">
						<label>Beli Buku</label>
						<input type="number" placeholder="Masukkan Jumlah Disini" min="1" class="form-control" name="jumlah" max="<?php echo number_format($detail["stokbuku"]); ?>" required></input>
						<br>
						<button class="btn btn-success float-end" name="beli"><i class="fa fa-shopping-cart"></i> Beli</button>
					</div>
				</form>
				<?php
				if (isset($_POST["beli"])) {
					$jumlah = $_POST["jumlah"];
					$_SESSION["keranjang"][$idbuku] = $jumlah;
					echo "<script> alert('Buku Masuk Ke Keranjang');</script>";
					echo "<script> location ='keranjang.php';</script>";
				}
				?>
	  </div>
	</div>
  </div>

</div>

</section>
</main>

<?php
include 'footer.php';
?>