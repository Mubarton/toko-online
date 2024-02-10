<?php
    require "session.php";
    require "../koneksi.php";

    $id = $_GET['id'];

    $query = mysqli_query($con, "SELECT * FROM kategori WHERE id='$id'");
    $data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="icon" href="../image/favicon.ico">
    <title>Detail Kategori</title>
</head>

<style>
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
                    <a href="../adminpanel" class="no-decoration">
                        <i class="fas fa-house"></i> Home
                    </a> 
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="kategori.php" class="no-decoration">
                        Kategori
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php 
                        echo $data['nama']
                    ?>
                </li>
            </ol>
        <h2>Detail Kategori</h2>
        </nav>
    
        <div class="col-12 col-md-6">
            <form action="" method="post">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo $data['nama']?>">
                </div>

                <div class="mt-5 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="editBTN">Edit</button>
                    <button type="submit" class="btn btn-danger" name="deleteBTN">Delete</button>
                </div>
            </form>

            <?php
                if(isset($_POST['editBTN'])){
                    $kategori = htmlspecialchars($_POST['kategori']);

                    if($data['nama'] == $kategori) {
                        ?>
                        <meta http-equiv="refresh" content="0 url=kategori.php"/>
                        <?php
                    } else{
                        $query = mysqli_query($con, "SELECT * FROM kategori WHERE nama='$kategori'");      
                        $jumlahData = mysqli_num_rows($query);
                        
                        if($jumlahData > 0) {
                            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                Kategori Sudah Ada
                            </div>
                            <?php
                        } else {
                            $querySimpan = mysqli_query($con,"UPDATE kategori SET nama='$kategori' WHERE id='$id'");
                            ?>    
                            <meta http-equiv="refresh" content="0; url=kategori.php" />
                            <?php
                        }
                    }
                }

                if(isset($_POST["deleteBTN"])){
                    $queryCheck = mysqli_query($con,"SELECT * FROM produk WHERE kategori_id='$id'");
                    $dataCount = mysqli_num_rows($queryCheck);

                    if($dataCount > 0) {
                        ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Kategori tidak dapat dihapus karena memiliki produk
                        </div>
                        <?php
                    } else {
                        $queryDelete = mysqli_query($con, "DELETE FROM kategori WHERE id='$id'");
                        ?>    
                        <meta http-equiv="refresh" content="0; url=kategori.php" />
                        <?php
                    }

                }
            ?>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>