<?php
require "koneksi.php";

$sql = mysqli_query($conn, "SELECT * FROM kategori");
function rupiah($angka)
{

    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}


// get produk by nama produk

if (isset($_GET['keyword'])) {
    $QueryProduk = mysqli_query($conn, "SELECT * FROM product WHERE nama LIKE '%$_GET[keyword]%'");
}

// get produk by kategori
else if (isset($_GET['kategori'])) {
    $queryGetKategoriId = mysqli_query($conn, "SELECT id FROM kategori WHERE nama = '$_GET[kategori]'");
    $kategoriByID = mysqli_fetch_array($queryGetKategoriId);

    $QueryProduk = mysqli_query($conn, "SELECT * FROM product WHERE kategori_id = '$kategoriByID[id]'");
}
// get all produk
else {
    $QueryProduk = mysqli_query($conn, "SELECT * FROM product");
}

$totalProduk = mysqli_num_rows($QueryProduk);

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

    <?php require "navbar-cs.php" ?>


    <!-- banner -->
    <div class="container-fluid banner-produk d-flex align-items-center">
        <div class="container">
            <h2 class="text-white text-center">Produk</h2>
        </div>
    </div>
    <!-- end banner -->


    <!-- content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5">
                <h3>Kategori</h3>
                <ul class="list-group">
                    <?php while ($kategori = mysqli_fetch_array($sql)): ?>
                    <a href="ProdukList.php?kategori=<?= $kategori['nama'] ?>" style="text-decoration:none;">
                        <li class="list-group-item"><?= $kategori['nama'] ?></li>
                    </a>
                    <?php endwhile; ?>
                </ul>
            </div>
            <div class="col-lg-9">
                <h3 class="text-center mb-3">Produk</h3>
                <div class="row">

                    <?php if ($totalProduk < 1) { ?>
                    <h4 class="text-center">Produk yang anda cari tidak ada</h4>
                    <?php } ?>
                    <?php while ($produk = mysqli_fetch_array($QueryProduk)): ?>
                    <div class="col-md-6  mb-4">
                        <div class="card" style="width: 18rem;">
                            <div class="image-box">
                                <img src="image/<?= $produk['foto'] ?>" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><?= $produk['nama'] ?></h4>
                                <p class="card-text text-truncate"><?= $produk['detail'] ?></p>
                                <p class="card-text text-harga"><?= rupiah($produk['harga']) ?></p>
                                <a href="ProdukSelengkapnya.php?nama=<?= $produk['nama'] ?>"
                                    class="btn btn-warning">Lihat Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- end content -->

    <!-- footer -->
    <?php require "footer.php" ?>
    <!-- end footer -->
</body>

</html>