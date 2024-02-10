<?php
    require "session.php";
    require "../koneksi.php";

    $queryProduk = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
    $jumlahProduk = mysqli_num_rows($queryProduk);

    $queryKategori = mysqli_query($con,"SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="icon" href="../image/favicon.ico">
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }

    form div {
        margin-bottom: .5em;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration">
                        <i class="fas fa-house"></i> Home
                    </a> 
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Produk
                </li>
            </ol>
        </nav>

        <!-- Tambah Produk -->
        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Produk</h3>

            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" required>
                </div>
                <div>
                    <label for="kategori" required>Kategori</label>
                    <select name="kategori" id="kategori" class="form-control">
                        <option value="" disabled selected>Pilih Satu</option>
                        <?php 
                            while($data = mysqli_fetch_array($queryKategori)) {
                        ?>
                            <option value="<?php echo$data['id'];?>"><?php echo $data['nama'];?></option>        
                        <?php    
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="harga">Harga</label>
                    <input type="number" id="harga" name="harga" class="form-control" autocomplete="off" required>
                </div>
                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="20" rows="5" class="form-control"></textarea>
                </div>
                <div>
                    <label for="stok">Stok</label>
                    <select name="stok" id="stok" class="form-control" required>
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="simpanProduk">Simpan</button>
                </div>
            </form>

            <?php 
                if(isset($_POST['simpanProduk'])) {
                    $nama = htmlspecialchars($_POST['nama']);
                    $kategori = htmlspecialchars($_POST['kategori']);
                    $harga = htmlspecialchars($_POST['harga']);
                    $detail = htmlspecialchars($_POST['detail']);
                    $stok = htmlspecialchars($_POST['stok']);
                    
                    // Upload Foto
                    $target_dir = "../image/";
                    $namaFile = basename($_FILES["foto"]["name"]);
                    $targetFile = $target_dir . $namaFile;
                    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                    $image_size = $_FILES["foto"]["size"];
                    $newName = $nama . "_" . $kategori .".". $imageFileType;

                    if($nama=='' || $kategori== ''|| $harga== '') {
            ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Isi Kategori, Nama, dan Harga terlebih dahulu
                        </div>
            <?php
                    } else {
                        if($namaFile !=''){
                            if($image_size >= 500000){
            ?>
                                <div class="alert alert-warning mt-3" role="alert">
                                    File tidak boleh lebih dari 500kb
                                </div>    
            <?php 
                            } else {
                                if($imageFileType !='jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' && $imageFileType != 'gif') {
            ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Tipe file tidak sesuai
                                    </div>    
            <?php   
                                } else {
                                    move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $newName);
                                }                
                            }
                        }

                        // Query Insert ke Tabel Produk
                        $queryTambah = mysqli_query($con,"INSERT INTO produk (kategori_id, nama, harga, foto, detail, ketersediaan_stok) VALUES ('$kategori', '$nama', '$harga', '$newName', '$detail', '$stok')");
                        ?>
                        <div class="alert alert-primary mt-3" role="alert">
                            Produk Berhasil Ditambahkan
                        </div>

                        <meta http-equiv="refresh" content="2; url=produk.php" />
                        <?php
                    }
                }
            ?>
        </div>

        <!-- List Produk -->
        <div class="mt-3 mb-5">
            <h2>List Produk</h2>

            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kategori</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $number = 1;
                            while ($data=mysqli_fetch_array($queryProduk)) {
                        ?>
                                <tr>
                                    <td><?php echo $number; ?></td>
                                    <td><?php echo $data['nama_kategori']; ?></td>
                                    <td><?php echo $data['nama']; ?></td>
                                    <td><?php echo "Rp. " . number_format($data['harga'], 0, ".", ".")?></td>
                                    <td><?php echo $data['ketersediaan_stok']; ?></td>
                                    <td>
                                        <a href="produk-detail.php?id=<?php echo $data['id']; ?>" class="btn btn-info"><i class="fas fa-search"></i></a>
                                    </td>
                                </tr>
                        <?php
                                $number++;
                            }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>