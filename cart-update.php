<?php
if (!isset($_SESSION)) {
    session_start();
}
include('config/koneksi.php');
$return_url = base64_decode($_GET["return_url"]);
if(empty($return_url)){
    $return_url = '/Kelompok1';
}
if (isset($_GET['id'])) {
    $Aid_barang = $_GET['id'];
    $ambil = $koneksi->query("SELECT * FROM tbl_barang WHERE id_barang='" . $Aid_barang . "'") or die("Last error: {$koneksi->error}\n");
    $rowcount = mysqli_num_rows($ambil);
    if ($rowcount > 0) {
        $pecah = $ambil->fetch_array();
        if (isset($_SESSION['cart'][$Aid_barang])) {
            $_SESSION['cart'][$Aid_barang] += 1;
        } else {
            $_SESSION['cart'][$Aid_barang] = 1;
        }
    }
} else {
    $Rid_barang = $_GET['hapuscart'];
    //remove item from shopping cart
    if (isset($_GET["hapuscart"]) && isset($_GET["return_url"]) && isset($_SESSION["cart"])) {
        unset($_SESSION["cart"][$Rid_barang]);
        //redirect back to original page
    }
}
header('Location:' . $return_url);
