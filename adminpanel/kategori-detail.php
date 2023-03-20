<?php

include "session.php";
include "../koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM kategori WHERE id = '$id'");
$data = mysqli_fetch_array($query);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <?php include "nav.php"; ?>

    <div class="container mt-4">
        <h2>Detail Kategori</h2>


        <div class="container col-12 col-md-12">
            <form method="POST">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" value="<?php echo $data['nama'] ?>"
                        class="form-control">
                </div>

                <div>
                    <button type="submit" name="edit" class="btn btn-info mt-3">Edit</button>
                    <button type="submit" name="delete" class="btn btn-danger mt-3">Delete</button>
                </div>
            </form>

            <?php
            if (isset($_POST['edit'])) {
                $nama = htmlspecialchars(ucwords(strtolower($_POST["kategori"])));

                if ($data['nama'] == $nama) {
                    header("refresh:0;kategori.php");
                } else {
                    $kueriCek = mysqli_query($conn, "SELECT * FROM kategori WHERE nama = '$nama'");
                    $jmlhData = mysqli_num_rows($kueriCek);

                    if ($jmlhData > 0) {
            ?>
            <div class="alert alert-warning mt-3" role="alert">
                Kategori sudah ada
            </div>

            <?php
                    } else {
                        $kategoriUpdate = mysqli_query($conn, "UPDATE kategori SET nama = '$nama' WHERE id = '$id'");

                    ?>
            <div class="alert alert-success mt-3" role="alert">
                Kategori berhasil diubah
            </div>
            <meta http-equiv="refresh" content="0.5; url=kategori.php">
            <?php
                    }
                }
                //     
                // $kategoriUpdate = mysqli_query($conn, "UPDATE kategori SET nama = '$nama' WHERE id = '$id'");
                // 
                // $kategoriUpdate = mysqli_query($conn, "UPDATE kategori SET nama = '$nama' WHERE id = '$id'");
            }


            if (isset($_POST['delete'])) {
                // untuk cek apakah kategori sudah memiliki produk
                $QueryCheck = mysqli_query($conn, "SELECT * FROM product WHERE kategori_id = '$id'");
                $dataCount = mysqli_num_rows($QueryCheck);

                if ($dataCount > 0) {
                    echo " <div class='alert alert-warning mt-3' role='alert'>
                                Kategori tidak bisa di hapus karena sudah memiliki produk
                            </div>";
                    die();
                }


                $kueriDelete = mysqli_query($conn, "DELETE FROM kategori WHERE id = '$id'");

                if ($kueriDelete) {
                    ?>
            <div class="alert alert-success mt-3" role="alert">
                Kategori berhasil dihapus
            </div>
            <meta http-equiv="refresh" content="1; url=kategori.php">
            <?php
                } else {
                    echo mysqli_error($conn);
                }
            }
            ?>
        </div>
    </div>



    <script script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
        </script>
</body>

</html>