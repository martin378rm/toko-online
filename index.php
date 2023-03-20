<?php
require "koneksi.php";
$queryProduk = mysqli_query($conn, "SELECT id, nama, harga, foto, detail FROM product LIMIT 6");

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
    <title>Toko Online | Home</title>
</head>

<body>

    <?php require "navbar-cs.php" ?>


    <!-- Start banner -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>Toko Online</h1>
            <h3>Mau cari apa</h3>
            <div class="col-md-8 offset-md-2">
                <form action="ProdukList.php" method="GET">
                    <div class="input-group input-lg my-4">
                        <input type="text" class="form-control" placeholder="Cari barang"
                            aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyword"
                            autocomplete="off">
                    </div>
                    <button class="btn btn-info" type="submit">Telusuri</button>
                </form>
            </div>
        </div>
    </div>

    <!-- End banner -->



    <!-- Start Highlight kategori -->

    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Kategori terlaris</h3>

            <div class="row mt-5">
                <div class="col-md-4 mb-4">
                    <div class="highlighted-kategori kategori-baju-pria d-flex justify-content-center align-items-center">
                        <h4>
                            <a style="text-decoration: none; color: white; " onMouseOver="this.style.color='#F8F988'" onMouseOut="this.style.color='white'" href="ProdukList.php?kategori = ">Baju pria
                            </a>
                        </h4>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="highlighted-kategori kategori-baju-wanita d-flex justify-content-center align-items-center">
                        <h4>
                            <a style="text-decoration: none; color: white;" onMouseOver="this.style.color='#F8F988'" onMouseOut="this.style.color='white'" href="ProdukList.php?kategori = ">Baju wanita
                            </a>
                        </h4>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="highlighted-kategori kategori-sepatu d-flex justify-content-center align-items-center">
                        <h4>
                            <a style="text-decoration: none; color: white;" onMouseOver="this.style.color='#F8F988'" onMouseOut="this.style.color='white'" href="ProdukList.php?kategori = ">Sepatu
                            </a>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Highlight kategori -->


    <!-- tentang kami -->
    <div class="container-fluid warna4 py-5">
        <div class="container text-center">
            <h3>Tentang Kami</h3>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quidem obcaecati mollitia magnam error in, enim officiis tempora repellendus sint quisquam earum voluptatibus doloribus? Esse minima quasi nemo provident vitae, corrupti rem culpa veniam delectus illum placeat, quisquam nam assumenda. Natus eum voluptatum tempora dicta consequatur esse? Numquam culpa mollitia velit optio aperiam reiciendis laudantium molestiae error non incidunt cum tenetur ab inventore, omnis quasi sapiente quis rerum modi maiores consectetur similique impedit! Explicabo dolor tenetur praesentium tempore, ex vitae. Repudiandae tempore ab quisquam soluta consequuntur similique sint rerum autem explicabo.</p>
        </div>
    </div>

    <!-- end tentang kami -->

    <!-- start produk -->

    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Produk</h3>
            
            <div class="row mt-5">
                <?php while ($data = mysqli_fetch_array($queryProduk)) { ?>
                    
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-3">
                    <div class="card" style="width: 18rem;">
                        <div class="image-box">
                        <img src="image/<?php echo $data['foto'] ?>" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $data['nama'] ?></h4>
                            <p class="card-text text-truncate"><?php echo $data['detail'] ?></p>
                            <p class="card-text text-harga">Rp.<?php echo $data['harga'] ?></p>
                            <a href="ProdukSelengkapnya.php?nama = <?php echo $data['nama']?>" class="btn btn-warning">Lihat Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- end produk -->


    <!-- footer -->
        <?php require "footer.php" ?>
    <!-- end footer -->

    <script script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
        </script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>