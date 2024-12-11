<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["akun"])) {
    echo "<script> alert('Harap login terlebih dahulu');</script>";
    echo "<script> location ='login.php';</script>";
}
$id = $_SESSION["akun"]["id"];
?>
<?php
$id = $_SESSION["akun"]['id'];
$ambil = $koneksi->query("SELECT *FROM akun WHERE id='$id'");
$pecah = $ambil->fetch_assoc(); ?>
<?php include 'header.php'; ?>
<main class="main">

    <div class="page-title dark-background" data-aos="fade" style="background-image: url(home/assets/img/bg1.jpg);">
        <div class="container">
            <h1>Akun</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="index.php">Home</a></li>
                    <li class="current">Akun</li>
                </ol>
            </nav>
        </div>
    </div>

    <section id="team" class="team section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Akun</h2>
        </div>
        <div class="container">
            <div class="row gy-4">
                <form method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="form-group">
                        <label class="mb-2">Nama</label>
                        <input value="<?php echo $pecah['nama']; ?>" type="text" value="" class="form-control mb-2" name="nama">
                    </div>
                    <div class="form-group">
                        <label class="mb-2">Email</label>
                        <input value="<?php echo $pecah['email']; ?>" type="email" class="form-control mb-2" name="email">
                    </div>
                    <div class="form-group">
                        <label class="mb-2">Telepon</label>
                        <input value="<?php echo $pecah['telepon']; ?>" type="number" class="form-control mb-2" name="telepon">
                    </div>
                    <div class="form-group">
                        <label class="mb-2">Alamat</label>
                        <textarea value="<?php echo $pecah['alamat']; ?>" class="form-control mb-2" name="alamat" id="alamat" rows="5"><?php echo $pecah['alamat']; ?></textarea>
                        <script>
                            CKEDITOR.replace('alamat');
                        </script>
                    </div>
                    <div class="form-group">
                        <label class="mb-2">Password</label>
                        <input type="text" class="form-control mb-2" name="password">
                        <input type="hidden" class="form-control" name="passwordlama" value="<?php echo $pecah['password']; ?>">
                        <span class="text-primary">Kosongkan Password jika tidak ingin mengganti</span>
                    </div>
                    <button class="btn btn-primary float-end" name="ubah"><i class="glyphicon glyphicon-saved"></i>Simpan</a></button>
                </form>
            </div>
        </div>
    </section>
</main>
<?php
if (isset($_POST['ubah'])) {
    if ($_POST['password'] == "") {
        $password = $_POST['passwordlama'];
    } else {
        $password = $_POST['password'];
    }

    $koneksi->query("UPDATE akun SET password='$password',nama='$_POST[nama]', email='$_POST[email]',telepon='$_POST[telepon]', alamat='$_POST[alamat]' WHERE id='$id'") or die(mysqli_error($koneksi));
    echo "<script>alert('Profil Berhasil Di Ubah');</script>";
    echo "<script>location='akun.php';</script>";
}
include 'footer.php';
?>