<?php
require_once "session.php";
require_once "../koneksi.php";

$kueri = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM product a JOIN kategori b ON a.kategori_id = b.id");
$jumlahProduk = mysqli_num_rows($kueri);

$kueryKategoriToProduct = mysqli_query($conn, "SELECT * FROM kategori");


// function untuk generate nama file

function generateRandomString($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <title>Document</title>
</head>

<style>
    .dekor {
        text-decoration: none;
    }

    form div {
        margin-bottom: 10px;
    }

    #kategori,
    #nama,
    #harga,
    #foto,
    #detail,
    #ketersediaan_stok {
        margin-top: 10px;
    }
</style>


<body>
    <?php include "nav.php" ?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="index.php" class="rumah text-muted dekor"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Produk
                </li>
            </ol>
        </nav>

        <!-- tambah produk -->
        <div class="my-5 col-12 col-md-6">
            <h3>Tambah produk</h3>


            <form method="POST" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" autocomplete="off" class="form-control">
                </div>

                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control">
                        <option value=""></option>
                        <?php
                        while ($dataKategori = mysqli_fetch_array($kueryKategoriToProduct)) {
                        ?>
                        <option value="<?php echo $dataKategori['id'] ?>">
                            <?php echo $dataKategori['nama'] ?>
                        </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="harga">Harga</label>
                    <input type="number" name="harga" id="harga" class="form-control">
                </div>

                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>

                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" rows="10" cols="30" class="form-control"></textarea>
                </div>

                <div>
                    <label for="ketersediaan_stok">Ketersediaan</label>
                    <select class="form-control" name="ketersediaan_stok" id="ketersediaan_stok">
                        <option value="tersedia">tersedia</option>
                        <option value="habis">habis</option>
                    </select>
                </div>

                <div>
                    <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
                </div>
            </form>


            <?php
            const br = "<br>";
            if (isset($_POST['simpan'])) {
                $nama = htmlspecialchars($_POST['nama']);
                $kategori = htmlspecialchars($_POST['kategori']);
                $harga = htmlspecialchars($_POST['harga']);
                $detail = htmlspecialchars($_POST['detail']);
                $ketersediaan = htmlspecialchars($_POST['ketersediaan_stok']);

                // untuk upload foto
            
                $target_dir = "../image/";
                $nama_file = basename($_FILES['foto']['name']);
                $target_file = $target_dir . $nama_file;
                $imageFileType = strtolower((pathinfo($target_file, PATHINFO_EXTENSION)));
                $image_size = $_FILES["foto"]["size"];
                $generateFileName = generateRandomString(20);
                $nameGenerateFile = $generateFileName . "." . $imageFileType;

                // echo $target_dir . br;
                // echo $nama_file . br;
                // echo $target_file . br;
                // echo $imageFileType . br;
                // echo $image_size . br;
            



                if ($nama == "" || $kategori == "" || $harga == "") {
            ?>
            <div class="alert alert-warning mt-3" role="alert">
                Nama,Kategori,Harga wajib diisi
            </div>
            <?php
                } else {
                    if ($nama_file != null) {
                        if ($image_size > 5000000) {
            ?>
            <div class="alert alert-warning mt-3" role="alert">
                Ukuran file lebih dari 5mb
            </div>
            <?php
                            die();
                        } else {
                            if ($imageFileType != 'jpeg' && $imageFileType != 'png' && $imageFileType != 'jpg' && $imageFileType != 'webp') {
            ?>
            <div class="alert alert-warning mt-3" role="alert">
                Type file salah
            </div>
            <?php
                                die();
                            } else {
                                move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $nameGenerateFile);
                            }
                        }
                    }

                    // insert to table produk
                    $insertToProduct = mysqli_query($conn, "INSERT INTO product (id,kategori_id, nama, harga, foto, detail, ketersediaan_stok) VALUES ('','$kategori', '$nama', '$harga','$nameGenerateFile' ,'$detail', '$ketersediaan')");

                    if ($insertToProduct) {
                        echo "  <div class='alert alert-success mt-3' role='alert'>
                                    Product berhasil tersimpan
                                </div>";
                        echo "<meta http-equiv='refresh' content='1; url=produk.php'>";
                    }
                }
            }



            ?>
        </div>

        <h2>List Produk</h2>

        <div class="table-responsive mt-5">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Ketersediaan stok</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if ($jumlahProduk == 0) {
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Produk tida tersedia</td>
                    </tr>
                    <?php
                    } else {
                        $no = 1;
                        while ($data = mysqli_fetch_array($kueri)) {

                    ?>
                    <tr>
                        <th>
                            <?= $no++ ?>
                        </th>
                        <th>
                            <?= $data['nama'] ?>
                        </th>
                        <th>
                            <?= $data['nama_kategori'] ?>
                        </th>
                        <th>
                            <?= $data['harga'] ?>
                        </th>
                        <th>
                            <?= $data['ketersediaan_stok'] ?>
                        </th>
                        <td>
                            <a href="detail-produk.php?id=<?php echo $data['id'] ?>" class="btn btn-info"><i
                                    class="fas fa-search"></i></a>
                        </td>
                    </tr>

                    <?php

                        }
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>





    <script src="../fontawesome/js/all.min.js"></script>
    <script script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
        </script>
</body>

</html>