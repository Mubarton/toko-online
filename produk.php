<?php 
    require "koneksi.php";
    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");

    // Produk per Nama Produk
    if(isset($_GET['keyword'])){
        $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama LIKE'%$_GET[keyword]%'");
    }
    // Produk per Kategori
    else if(isset($_GET['kategori'])){
        $queryGetKategoriId = mysqli_query($con,"SELECT id FROM kategori WHERE nama='$_GET[kategori]'");
        $kategoriId = mysqli_fetch_array($queryGetKategoriId);
        $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='$kategoriId[id]'");
    }
    // Produk Default
    else {
        $queryProduk = mysqli_query($con, "SELECT * FROM produk");
    }

    $countData = mysqli_num_rows($queryProduk);
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
    <title>Produk</title>
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid banner-produk d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center">Produk</h1>
        </div>
    </div>

    <!-- Body -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5">
                <h3>Kategori</h3>
                <ul class="list-group">
                    <?php while($kategori = mysqli_fetch_array($queryKategori)){ ?>
                    <a href="produk.php?kategori=<?php echo $kategori['nama']?>" class="no-decoration">
                        <li class="list-group-item"><?php echo $kategori['nama'] ?></li>
                    </a>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-lg-9">
                <h3 class="text-center mb-3">Produk</h3>
                <div class="row">
                    <?php 
                        if($countData < 1){
                    ?>
                        <h4 class="text-center my-5">Produk yang anda cari tidak tersedia</h4>
                    <?php
                        }
                    ?>
                    <?php while($produk = mysqli_fetch_array($queryProduk)) { ?>
                    <div class="col-sm-6 col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="image-box">
                                <img src="image/<?php echo $produk['foto']?>" class="card-img-top" alt="<?php echo $data['nama']?>">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $produk['nama']?></h4>
                                <p class="card-text text-truncate"><?php echo $produk['detail']?></p>
                                <p class="card-text fs-3"><?php echo "Rp. " . number_format($produk['harga'], 0, ".", ".")?></p>
                                <a href="produk-detail.php?nama=<?php echo $produk['nama']?>" class="btn btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php require "footer.php"; ?>
    <script src="bootstrap/js/bootstrap.bundle.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>