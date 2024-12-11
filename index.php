<?php
session_start();
include 'koneksi.php';
?>

<?php include 'header.php'; ?>
<main class="main">

	<!-- Hero Section -->
	<section id="hero" class="hero section dark-background">

		<img src="home/assets/img/bg1.jpg" alt="" data-aos="fade-in">

		<div class="container">
			<div class="row">
				<div class="col-xl-4">
					<h1 data-aos="fade-up">Selamat Datang di Toko Buku Kami</h1>
					<blockquote data-aos="fade-up" data-aos-delay="100">
						<p>Temukan beragam koleksi buku favorit Anda di sini. Dari fiksi hingga non-fiksi, kami menyediakan buku untuk setiap pembaca dengan kualitas terbaik.</p>
					</blockquote>

					<div class="d-flex" data-aos="fade-up" data-aos-delay="200">
						<a href="buku.php" class="btn-get-started">Lihat Koleksi Buku Kami</a>
					</div>
				</div>
			</div>
		</div>

	</section>

	<section id="why-us" class="why-us section">
		<div class="container">
			<div class="row g-0">
				<div class="col-xl-5 img-bg" data-aos="fade-up" data-aos-delay="100">
					<img src="home/assets/img/bg2.jpg" alt="">
				</div>
				<div class="col-xl-7 slides position-relative" data-aos="fade-up" data-aos-delay="200">
					<div class="swiper init-swiper">
						<script type="application/json" class="swiper-config">
							{
								"loop": true,
								"speed": 600,
								"autoplay": {
									"delay": 5000
								},
								"slidesPerView": "auto",
								"centeredSlides": true,
								"pagination": {
									"el": ".swiper-pagination",
									"type": "bullets",
									"clickable": true
								},
								"navigation": {
									"nextEl": ".swiper-button-next",
									"prevEl": ".swiper-button-prev"
								}
							}
						</script>
						<div class="swiper-wrapper">

							<div class="swiper-slide">
								<div class="item">
									<h3 class="mb-3">Mari Temukan Buku Favoritmu</h3>
									<h4 class="mb-3">Raih inspirasi dan pengetahuan dari berbagai koleksi buku pilihan kami.</h4>
									<p>Temukan novel menarik, buku pelajaran, hingga karya sastra klasik yang dapat menemani hari Anda. Kami menyediakan berbagai genre yang sesuai dengan minat Anda, dari fiksi hingga non-fiksi, dengan kualitas terbaik.</p>
								</div>
							</div>

							<div class="swiper-slide">
								<div class="item">
									<h3 class="mb-3">Kisah yang Menginspirasi</h3>
									<h4 class="mb-3">Buku adalah jendela dunia untuk memperluas wawasan dan menggugah imajinasi.</h4>
									<p>Dapatkan buku-buku inspiratif yang penuh makna, dari biografi tokoh terkenal hingga buku motivasi. Setiap halaman membawa Anda pada petualangan baru dan ide-ide segar yang dapat mengubah hidup.</p>
								</div>
							</div>

							<div class="swiper-slide">
								<div class="item">
									<h3 class="mb-3">Jelajahi Dunia dengan Buku</h3>
									<h4 class="mb-3">Bawa pulang cerita-cerita menarik yang akan membuat Anda terpikat.</h4>
									<p>Kami menyediakan buku-buku terbaik yang dapat menemani waktu luang Anda. Dari buku anak hingga ensiklopedia, nikmati pengalaman membaca yang menyenangkan hanya di toko buku kami.</p>
								</div>
							</div>
						</div>
						<div class="swiper-pagination"></div>
					</div>

					<div class="swiper-button-prev"></div>
					<div class="swiper-button-next"></div>
				</div>
			</div>
		</div>
	</section>
	<section id="team" class="team section">
		<div class="container section-title" data-aos="fade-up">
			<h2>Buku Kami</h2>
		</div>
		<div class="container">
			<div class="row gy-4">
			<?php $ambil = $koneksi->query("SELECT *FROM buku LEFT JOIN kategori ON buku.id_kategori=kategori.id_kategori order by idbuku desc limit 3"); ?>
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