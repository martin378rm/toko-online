<?php
include "session.php";
include "../koneksi.php";


$queryKategori = mysqli_query($conn, "SELECT * FROM kategori");
$jumlahKategori = mysqli_num_rows($queryKategori);

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
    .rumah {
        text-decoration: none;
    }
</style>



<body>
    <?php include "nav.php"; ?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="index.php" class="rumah text-muted"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Kategori
                </li>
            </ol>
        </nav>

        <div class="my-5 col-12 col-md-6">
            <h3>Tambah kategori</h3>

            <form method="POST">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" id="kategori" name="kategori" placeholder="input data kategori"
                        class="form-control mt-2">
                </div>

                <div class="mt-3">
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $kategori = htmlspecialchars(ucwords(strtolower($_POST['kategori'])));
                $queryCek = mysqli_query($conn, "SELECT * FROM kategori WHERE nama = '$kategori'");
                $jumlahKategoriBaru = mysqli_num_rows($queryCek);


                if ($jumlahKategoriBaru > 0) {
            ?>
            <div class="alert alert-warning mt-3" role="alert">
                Kategori sudah ada
            </div>
            <?php
                } else {

                    if ($kategori == null) {
                    ?>
            <!-- <div class="alert alert-success mt-3" role="alert">
                            
                        </div>
                        <meta http-equiv="refresh" content="3"> -->
            <?php
                    } else {
                        $sqlInsert = mysqli_query($conn, "INSERT INTO kategori (nama) VALUES ('$kategori')");
                        echo "<div class='alert alert-success mt-3' role='alert'>
                                Success
                            </div>";
                        echo "<meta http-equiv='refresh' content='0.5'>";
                    }
                }
            }

            ?>

        </div>

        <div class="mt-3">
            <h2>List Kategori</h2>

            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if ($jumlahKategori <= 0) {
                        ?>
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data kategori</td>
                        </tr>
                        <?php

                        } else {
                            $nomor = 1;
                            while ($data = mysqli_fetch_array($queryKategori)) {
                            ?>
                        <tr>
                            <td>
                                <?php echo $nomor ?>
                            </td>
                            <td>
                                <?php echo $data['nama'] ?>
                            </td>
                            <td>
                                <a href="kategori-detail.php?id=<?php echo $data['id'] ?>" class="btn btn-info"><i
                                        class="fas fa-search"></i></a>
                            </td>
                        </tr>


                        <?php
                                $nomor++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script src="../fontawesome/js/all.min.js"></script>
    <script script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
        </script>
</body>

</html>