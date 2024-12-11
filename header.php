<?php
include 'koneksi.php';
$datakategori = array();
$ambil = $koneksi->query("SELECT * FROM kategori");
while ($tiap = $ambil->fetch_assoc()) {
  $datakategori[] = $tiap;
}
function tanggal($tgl)
{
  $tanggal = substr($tgl, 8, 2);
  $bulan = getBulan(substr($tgl, 5, 2));
  $tahun = substr($tgl, 0, 4);
  return $tanggal . ' ' . $bulan . ' ' . $tahun;
}
function getBulan($bln)
{
  switch ($bln) {
    case 1:
      return "Januari";
      break;
    case 2:
      return "Februari";
      break;
    case 3:
      return "Maret";
      break;
    case 4:
      return "April";
      break;
    case 5:
      return "Mei";
      break;
    case 6:
      return "Juni";
      break;
    case 7:
      return "Juli";
      break;
    case 8:
      return "Agustus";
      break;
    case 9:
      return "September";
      break;
    case 10:
      return "Oktober";
      break;
    case 11:
      return "November";
      break;
    case 12:
      return "Desember";
      break;
  }
}
?>
 <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Toko Buku</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="home/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="home/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="home/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="home/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="home/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="home/assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center">
        <h1 class="sitename">Toko Buku</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php" class="">Home<br></a></li>
          <li><a href="buku.php">Buku</a></li>
          <li class="dropdown"><a href="#"><span>Kategori</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
            <?php foreach ($datakategori as $key => $value) : ?>
              <li><a href="kategori.php?id=<?php echo $value["id_kategori"] ?>"><?php echo $value["nama_kategori"] ?></a></li>
              <?php endforeach ?>
            </ul>
          </li>
          <?php
          if (isset($_SESSION["akun"])) { ?>
            <?php
              $id = $_SESSION["akun"]['id'];
              $ambil = $koneksi->query("SELECT *FROM akun WHERE id='$id'");
              $pecah = $ambil->fetch_assoc(); ?>
          <li class="dropdown"><a href="#"><span>Akun</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="akun.php">Profil Akun</a></li>
              <li><a href="keranjang.php">Keranjang</a></li>
              <li><a href="riwayat.php">Riwayat Pembelian</a></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </li>
          <?php } else { ?>
          <li><a href="daftar.php">Daftar</a></li>
          <li><a href="Login.php">Login</a></li>
          <?php } ?>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>
