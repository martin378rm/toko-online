<?php
require "koneksi.php";

$nama = htmlspecialchars($_GET['nama']);
$queryProduk = mysqli_query($conn, "SELECT * FROM product WHERE nama = '$nama' ");
$produk = mysqli_fetch_array($queryProduk);

$produkTerkait = mysqli_query($conn, "SELECT * FROM product WHERE kategori_id = '$produk[kategori_id]' AND id != '$produk[id]' LIMIT 4");



// format angka jadi uang
function rupiah($angka)
{

    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}
?>

<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <?php include "navbar-cs.php" ?>


    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-4">
                    <img src="image/<?= $produk['foto'] ?>" class="w-100" alt="">
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <h1><?= $produk['nama'] ?></h1>
                    <p class="fs-3"><?= $produk['detail'] ?> </p>
                    <p class="fs-5"><?= rupiah($produk['harga']) ?> </p>
                    <p class="fs-5">Status : <b><?= $produk['ketersediaan_stok'] ?></b></p>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid py-5 warna4">
        <div class="container">
            <h2 class="text-center text-white">Produk Terkait</h2>

            <div class="row">
                <?php while ($data = mysqli_fetch_array($produkTerkait)) { ?>
                <div class="col-md-6 col-lg-3 mb-3">
                    <a href="ProdukSelengkapnya.php?nama=<?= $data['nama'] ?>"><img src="image/<?= $data['foto'] ?>"
                            class="img-fluid img-thumbnail"></a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>


    <?php require "footer.php" ?>

    <script script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
        </script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>