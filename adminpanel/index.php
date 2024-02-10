<?php
    require "session.php";
    require "../koneksi.php";

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);
    
    $queryProduk = mysqli_query($con, "SELECT * FROM produk");
    $jumlahProduk = mysqli_num_rows($queryProduk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="icon" href="../image/favicon.ico">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
    .summary-kategori {
        border-radius: 15px;
    }

    .summary-produk {
        border-radius: 15px;
    }

    .no-decoration {
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-house"></i> Home
                </li>
            </ol>
        </nav>
        <h2>Halo admin</h2>

        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-kategori p-3 bg-primary">
                        <div class="row">
                            <div class="col-6">
                                <i class="fas fa-list fa-7x text-white"></i>
                            </div>
                            <div class="col-6">
                                <h3 class="fs-2 text-white">Kategori</h3>
                                <p class="fs-4 text-white"><?php echo "$jumlahKategori Kategori" ?></p>
                                <p><a href="kategori.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-produk p-3 bg-primary">
                        <div class="row">
                            <div class="col-6">
                                <i class="fas fa-box fa-7x text-white"></i>
                            </div>
                            <div class="col-6">
                                <h3 class="fs-2 text-white">Produk</h3>
                                <p class="fs-4 text-white"><?php echo "$jumlahProduk Produk" ?></p>
                                <p><a href="produk.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>