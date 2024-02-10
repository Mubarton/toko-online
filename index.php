<?php
    require "koneksi.php";
    $queryProduk = mysqli_query($con,"SELECT id, nama, harga, foto, detail FROM produk LIMIT 6");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="image/favicon.ico">
    <title>Beranda</title>
</head>
<body>
    <?php require "navbar.php"; ?>

    <!-- Hero -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>Marketplace Mubarton UNIMED</h1>
            <h3>Lagi cari apa nih?</h3>
            <div class="col-md-8 offset-md-2">
                <form method="get" action="produk.php">
                    <div class="input-group input-group-lg my-4">
                        <input type="text" class="form-control" placeholder="Nama Barang" aria-describedby="basic-addon2" name="keyword">
                        <button type="submit" class="btn btn-primary">Telusuri</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Kategori Utama -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Kategori Terlaris</h3>

            <div class="row mt-5">
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-1 d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a href="produk.php?kategori=Tas Wanita" class="text-white">Tas Wanita</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-2 d-flex justify-content-center align-items-center">
                        <h4><a href="produk.php?kategori=Tas Pria" class="text-white">Tas Pria</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-3 d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a href="produk.php?kategori=Tas Anak Perempuan" class="text-white">Tas Anak Perempuan</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tentang Kami -->
    <div class="container-fluid bg-primary text-white py-5">
        <div class="container text-center">
            <p class="fs-5 mt-3">
                Selamat datang di Marketplace Mubarton!!!, Marketplace Mubarton memiliki tujuan sebagai katalog untuk produk yang kita miliki, dan juga mempermudah teman-teman mahasiswa yang lain mengenal produk kita. Dengan pasar mahasiswa UNIMED membuat transaksi didalam kampus lebih mudah dan lebih mengenal produk-produk yang ada di area kampus.
            </p>
        </div>
    </div>

    <!-- Produk -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Produk</h3>

            <div class="row mt-5">
                <?php while($data=mysqli_fetch_array($queryProduk)) { ?>
                <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="image-box">
                            <img src="image/<?php echo $data['foto']?>" class="card-img-top" alt="<?php echo $data['nama']?>">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $data['nama']?></h4>
                            <p class="card-text text-truncate"><?php echo $data['detail']?></p>
                            <p class="card-text fs-3"><?php echo "Rp. " . number_format($data['harga'], 0, ".", ".")?></p>
                            <a href="produk-detail.php?nama=<?php echo $data['nama']?>" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <a class="btn btn-outline-primary mt-3 p-1 fs-5" href="produk.php">Lainnya</a>
        </div>
    </div>

    <!-- Footer -->
    <?php require "footer.php"; ?>

    <script src="bootstrap/js/bootstrap.bundle.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>