<?php

include "session.php";
include "../koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM product a JOIN kategori b ON a.kategori_id = b.id WHERE a.id = '$id'");
$data = mysqli_fetch_array($query);

$kueryKategoriToProduct = mysqli_query($conn, "SELECT * FROM kategori WHERE id != '$data[kategori_id]'");


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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>

    <?php include "nav.php"; ?>
    <div class="container mt-4">
        <h2>Detail Produk</h2>

        <div class="container col-12 col-md-12">
            <form method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" value="<?php echo $data['nama'] ?>" class="form-control">
                </div>

                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control">
                        <option value="<?php echo $data['kategori_id']?>"><?php echo $data['nama_kategori'] ?></option>
                        <?php
                        while ($dataKategori = mysqli_fetch_array($kueryKategoriToProduct)) {
                        ?>
                            <option value="<?php echo $dataKategori['id'] ?>"><?php echo $dataKategori['nama'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="harga">Harga</label>
                    <input type="number" name="harga" id="harga" value="<?php echo $data['harga'] ?>" class="form-control">
                </div>
                <div>
                        <label for="foto"></label>
                        <img src="../image/<?php echo $data['foto'] ?>" alt="" width="200" height="200" class="mt-3" name="foto">
                </div>
                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div> 
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" rows="10" cols="30" class="form-control"><?php echo $data['detail'] ?></textarea>
                </div>
                <div>
                    <label for="ketersediaan_stok">Ketersediaan</label>
                    <select class="form-control" name="ketersediaan_stok" id="ketersediaan_stok">
                        <option value="<?php echo $data['ketersediaan_stok']?>"><?php echo $data['ketersediaan_stok']?></option>
                        <<?php 
                            if($data['ketersediaan_stok'] == "tersedia"){
                        ?>
                                <option value="habis">habis</option>
                        
                        <?php 
                            } else {
                        ?>
                            <option value="tersedia">tersedia</option>
                        <?php
                            }
                        ?>
                    </select>
                </div> 
                <div>
                    <button type="submit" name="simpan" class="btn btn-success mt-4">Simpan</button>
                    <button type="submit" name="hapus" class="btn btn-danger mt-4">Hapus</button>
                    <input class="btn btn-primary mt-4" type="button" name="kembali" value="Kembali" onclick="self.history.back()">
                </div>
            </form>
        </div>
    </div>

    <?php 
    if (isset($_POST['simpan'])) {
        $nama = htmlspecialchars($_POST['nama']);
        $kategori = htmlspecialchars($_POST['kategori']);
        $harga = htmlspecialchars($_POST['harga']);
        $detail = htmlspecialchars($_POST['detail']);
        $ketersediaan = htmlspecialchars($_POST['ketersediaan_stok']);
        
        // untuk upload foto
        
        $target_dir = "../image/";
        $generateFileName = generateRandomString(20);
        $nama_file = basename($_FILES['foto']['name']);
        $target_file = $target_dir . $nama_file;
        $imageFileType = strtolower((pathinfo($target_file, PATHINFO_EXTENSION)));
        $image_size = $_FILES["foto"]["size"];
        $nameGenerateFile = $generateFileName . "." . $imageFileType;


        if ($nama == "" || $kategori == "" || $harga == "") {
            echo "  <div class='alert alert-warning mt-3' role='alert'>
                        Nama,Kategori,Harga wajib diisi
                    </div>";
        } else {
            $updateDetailProduk = mysqli_query($conn, " UPDATE product SET kategori_id = '$kategori', nama = '$nama', harga = '$harga', detail = '$detail', ketersediaan_stok = '$ketersediaan' WHERE id = $id ");

            if ($nama_file != null) {
                if ($image_size > 5000000) {

                    echo "<div class='alert alert-warning mt-3' role='alert'>
                                Ukuran file lebih dari 5mb
                            </div>";
                    die();

                } else {
                    if ($imageFileType != 'jpeg' && $imageFileType != 'png' && $imageFileType != 'jpg' && $imageFileType != 'webp') {
        ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                    Type file salah
                            </div>
        <?php            


                    } else {
                        move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $nameGenerateFile);

                        $QueryUpdate = mysqli_query($conn, "UPDATE product SET foto = '$nameGenerateFile' WHERE id = $id");


                        if($QueryUpdate) {
        ?>
                            <div class="alert alert-success mt-3" role="alert">
                                    Foto berhasil diupdate
                            </div>
                            <meta http-equiv="refresh" content="1; url=produk.php">
        <?php
                        }
                    }
                }
            }
        }
    }
    
    
    if (isset($_POST['hapus'])) {
        $delete = mysqli_query($conn, "DELETE FROM product WHERE id = $id ");

        if($delete) {
    ?>
                    <div class="alert alert-success mt-3" role="alert">
                        Produk berhasil dihapus
                    </div>
                    <meta http-equiv="refresh" content="1; url=produk.php">
    <?php
        }
    }
    
    ?>

<br><br><br><br><br>



    <script script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
        </script>
</body>

</html>