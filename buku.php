<?php
session_start();
include 'koneksi.php';
?>

<?php include 'header.php'; ?>
<main class="main">

<div class="page-title dark-background" data-aos="fade" style="background-image: url(home/assets/img/bg1.jpg);">
  <div class="container">
    <h1>Buku</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="index.php">Home</a></li>
        <li class="current">Buku</li>
      </ol>
    </nav>
  </div>
</div>

<section id="team" class="team section">
		<div class="container section-title" data-aos="fade-up">
			<h2>Buku Kami</h2>
		</div>
		<div class="container">
			<div class="row gy-4">
            <?php $ambil = $koneksi->query("SELECT *FROM buku LEFT JOIN kategori ON buku.id_kategori=kategori.id_kategori order by idbuku desc"); ?>
            <?php while ($perbuku = $ambil->fetch_assoc()) { ?>
				<div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
					<div class="team-member">
						<div class="member-img">
							<img width="100%" style="height: 600px;object-fit:cover" src="foto/<?php echo $perbuku['fotobuku'] ?>" class="img-fluid" alt="">
							
						</div>
						<div class="member-info">
							<h4><?php echo $perbuku["namabuku"] ?></h4>
							<span><?= $perbuku['nama_kategori'] ?></span>
							<p class="mb-2"><span class="price price-sale"></span> <span class="price">Rp <?php echo number_format($perbuku['hargabuku']) ?></span></p>
							<a href="detail.php?id=<?php echo $perbuku['idbuku']; ?>" class="btn btn-primary w-100">Beli Buku</a>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</section>
</main>
<?php
include 'footer.php';
?>