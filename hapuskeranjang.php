<?php 
session_start();
$idbuku=$_GET["id"];
unset($_SESSION["keranjang"][$idbuku]);
include 'koneksi.php';

echo "<script> alert('Buku Terhapus');</script>";
echo "<script> location ='keranjang.php';</script>";
