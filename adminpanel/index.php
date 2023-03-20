<?php
include "session.php";
include "../koneksi.php";

$queryKategori = mysqli_query($conn, "SELECT * FROM kategori");
$jumlahKategori = mysqli_num_rows($queryKategori);


$queryProduk = mysqli_query($conn, "SELECT * FROM product");
$jumlahProduk = mysqli_num_rows($queryProduk);



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <title>Halaman admin</title>
</head>

<style>
    .kotak {
        border: solid;
    }

    .summary-kategori {
        background-color: #A1c7bc;
        border-radius: 25px;
    }

    .summary-produk {
        background-color: #A1c7bc;
        border-radius: 25px;
    }

    .detail {
        text-decoration: none;
    }

    .detail:hover {
        background-color: #Cce4e4;
        border-radius: 6px;
    }
</style>


<body>
    <?php
    include "nav.php";
    ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-home"></i> Home
                </li>
            </ol>
        </nav>
        <h2>Hallo
            <?php echo $_SESSION["username"] ?>
        </h2>

        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-kategori p-3">
                        <div class="row">
                            <div class="col-6">
                                <i class="fa-solid fa-burger fa-6x"></i>
                            </div>
                            <div class="col-6">
                                <h3>Kategori</h3>
                                <p>
                                    <?= $jumlahKategori ?> Kategori
                                </p>
                                <p><a href="kategori.php" class="text-white detail">Lihat detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12">
                    <div class="summary-produk p-3">
                        <div class="row">
                            <div class="col-6">
                                <i class="fa-solid fa-box fa-6x"></i>
                            </div>
                            <div class="col-6">
                                <h3>Produk</h3>
                                <p>
                                    <?= $jumlahProduk ?> Produk
                                </p>
                                <p><a href="produk.php" class="text-white detail">Lihat detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
</body>
</body>

</html>