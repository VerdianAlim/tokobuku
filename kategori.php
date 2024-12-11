<?php
session_start();
include 'koneksi.php';

?>

<?php include 'header.php';
$kategori = $_GET["id"];


$semuadata = array();
$ambil = $koneksi->query("SELECT*FROM buku WHERE id_kategori LIKE '%$kategori%'");
while ($pecah = $ambil->fetch_assoc()) {
	$semuadata[] = $pecah;
}
?>
<?php
$datakategori = array();
$ambil = $koneksi->query("SELECT * FROM kategori");
while ($tiap = $ambil->fetch_assoc()) {
	$datakategori[] = $tiap;
}
?>
<?php $am = $koneksi->query("SELECT * FROM kategori where id_kategori='$kategori'");
$pe = $am->fetch_assoc()
?>
<main class="main">

<div class="page-title dark-background" data-aos="fade" style="background-image: url(home/assets/img/bg1.jpg);">
  <div class="container">
    <h1>Kategori : <?php echo $pe["nama_kategori"] ?></h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="index.php">Home</a></li>
        <li class="current">Kategori : <?php echo $pe["nama_kategori"] ?></li>
      </ol>
    </nav>
  </div>
</div>

<section id="team" class="team section">
		<div class="container section-title" data-aos="fade-up">
			<h2>Kategori : <?php echo $pe["nama_kategori"] ?></h2>
		</div>
		<div class="container">
			<div class="row gy-4">
			<?php foreach ($semuadata as $key => $value) : ?>
				<div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
					<div class="team-member">
						<div class="member-img">
							<img width="100%" style="height: 600px;object-fit:cover" src="foto/<?php echo $value['fotobuku'] ?>" class="img-fluid" alt="">
							
						</div>
						<div class="member-info">
							<h4><?php echo $value["namabuku"] ?></h4>
							<span><?= $pe['nama_kategori'] ?></span>
							<p class="mb-2"><span class="price price-sale"></span> <span class="price">Rp <?php echo number_format($value['hargabuku']) ?></span></p>
							<a href="detail.php?id=<?php echo $perbuku['idbuku']; ?>" class="btn btn-primary w-100">Beli Buku</a>
						</div>
					</div>
				</div>
				<?php endforeach ?>
				</div>
		</div>
	</section>
</main>

<?php
include 'footer.php';
?>