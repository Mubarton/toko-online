<?php 
    require "koneksi.php";
    
    $nama = htmlspecialchars($_GET['nama']);
    $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama='$nama'");
    $produk = mysqli_fetch_array($queryProduk);

    $queryProdukTerkait = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='$produk[kategori_id]' AND id!='$produk[id]' LIMIT 4");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="icon" href="image/favicon.ico">
    <title>Detail Produk</title>
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid py-5" >
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-lg-5 mb-3">
                    <img src="image/<?php echo $produk['foto']?>" alt="" class="w-100">
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <h1><?php echo $produk['nama'] ?></h1>
                    <p class="fs-5"><?php echo $produk['detail'] ?></p>
                    <p class="fs-3"><?php echo "Rp. " . number_format($produk['harga'], 0, ".", ".")?></p>
                    <p class="fs-5">Status Ketersediaan: <strong><?php echo $produk['ketersediaan_stok'] ?></strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Produk Terkait -->
    <div class="container-fluid py-5">
        <div class="container">
            <h2 class="text-center mb-5">Produk Terkait</h2>
            <div class="row">
                <?php while($data = mysqli_fetch_array($queryProdukTerkait)){ ?>
                <div class="col-md-6 col-lg-3 mb-3">
                    <a href="produk-detail.php?nama=<?php echo $data['nama']?>">
                        <img src="image/<?php echo $data['foto']?>" class="img-fluid img-thumbnail" alt="" style="height:100%; width:100%; object-fit:cover; object-position:center;">
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php require "footer.php"; ?>
    <script src="bootstrap/js/bootstrap.bundle.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>