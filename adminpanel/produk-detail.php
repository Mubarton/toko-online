<?php
    require "session.php";
    require "../koneksi.php";

    $id = $_GET['id'];

    $query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id WHERE a.id='$id'");
    $data = mysqli_fetch_array($query);

    $queryKategori = mysqli_query($con,"SELECT * FROM kategori WHERE id!='$data[kategori_id]'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="icon" href="../image/favicon.ico">
    <title>Detail Produk</title>
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5 mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration">
                        <i class="fas fa-house"></i> Home
                    </a> 
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="produk.php" class="no-decoration">
                        Produk
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php 
                        echo $data['nama']
                    ?>
                </li>
            </ol>
        <h2>Detail Produk</h2>
        </nav>
    
        <div class="col-12 col-md-6">
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" value="<?php echo $data['nama']?>" required>
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control">
                        <option value="<?php echo $data['kategori_id']?>" selected><?php echo $data['nama_kategori']?></option>
                        <?php 
                            while($dataKategori = mysqli_fetch_array($queryKategori)) {
                        ?>
                            <option value="<?php echo $dataKategori['id'];?>"><?php echo $dataKategori['nama'];?></option>        
                        <?php    
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="harga">Harga</label>
                    <input type="number" id="harga" name="harga" class="form-control" value="<?php echo $data['harga'];?>" autocomplete="off" required>
                </div>
                <div>
                    <label for="currentFoto">Foto Produk Sekarang</label>
                    <img src="../image/<?php echo $data['foto'];?>" alt="<?php echo $data['nama']?>" width="300px" class="my-3">
                </div>
                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="20" rows="5" class="form-control">
                        <?php echo $data['detail']?>
                    </textarea>
                </div>
                <div>
                    <label for="stok">Stok</label>
                    <select name="stok" id="stok" class="form-control" required>
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>
                <div class="mt-5 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="editBTN">Edit</button>
                    <button type="submit" class="btn btn-danger" name="deleteBTN">Delete</button>
                </div>
            </form>

            <?php
                if(isset($_POST['editBTN'])){
                    $nama = htmlspecialchars($_POST['nama']);
                    $kategori = htmlspecialchars($_POST['kategori']);
                    $harga = htmlspecialchars($_POST['harga']);
                    $detail = htmlspecialchars($_POST['detail']);
                    $stok = htmlspecialchars($_POST['stok']);

                    $target_dir = "../image/";
                    $namaFile = basename($_FILES["foto"]["name"]);
                    $targetFile = $target_dir . $namaFile;
                    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                    $image_size = $_FILES["foto"]["size"];
                    $newName = $id . "_" . $kategori . "." . $imageFileType;

                    if($nama=='' || $kategori== ''|| $harga== '') {
                        ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Isi Kategori, Nama, dan Harga terlebih dahulu
                        </div>
                        <?php
                    } else {
                        $queryUpdate = mysqli_query($con, "UPDATE produk SET kategori_id='$kategori', nama='$nama', harga='$harga', detail='$detail', ketersediaan_stok='$stok' WHERE id='$id'");

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
                                    $queryUpdate = mysqli_query($con, "UPDATE produk SET foto='$newName' WHERE id='$id'");
                                    ?>
                                    <div class="alert alert-primary mt-3" role="alert">
                                        Produk Berhasil di Update
                                    </div>
            
                                    <meta http-equiv="refresh" content="2; url=produk.php" />
                                    <?php
                                }                
                            }
                        }
                    }
                }

                if(isset($_POST["deleteBTN"])){
                    $queryDelete = mysqli_query($con, "DELETE FROM produk WHERE id='$id'");
                    ?>    
                    <meta http-equiv="refresh" content="0; url=produk.php" />
                    <?php
                }
            ?>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>