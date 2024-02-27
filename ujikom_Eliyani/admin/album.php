<?php
session_start();
include '../config/koneksi.php';
if($_SESSION['status']!='login'){
  echo "<script>
  alert('Anda belum Login!');
  location.href='../index.php';
  </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Gallery Foto</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary bg-info border-bottom">
  <div class="container">
    <a class="navbar-brand text-white" href="index.php">Website Galerry Foto</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
    <div class="navbar-nav me-auto"></div>
    <ul class="navbar-nav">
       <li class="nav-item"><a href="home.php" class="nav-link text-white"><i class="bi bi-house-door-fill">Home</i></a></li>
       <a href="album.php" class="nav-link text-dark"><i class="bi bi-journal-album">Album</i></a>
       <a href="foto.php" class="nav-link text-white"><i class="bi bi-file-image">Foto</i></a>
        </div>
        </ul>
  </div>
  <a href="../config/proses_logout.php" class="btn btn-outline-danger m-1 text-white"><i class="bi bi-box-arrow-right"></i></a>
</nav>


<div class="container table-responsive">
  <div class="row">
    <div class="col-md-4">
      <div class="card mt-2">
        <div class="card-header">Tambah Album</div>
        <div class="card-body">
          <form action="../config/proses_album.php" method="POST">
            <label class="form-label text-dark">Nama Album</label>
            <input type="text" name="namaalbum" class="form-control" required>
            <label class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" required></textarea>
            <button type="submit" class="btn btn-primary mt-2" name="tambah">Tambah</button>
          </form> 
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="card mt-2">
        <div class="card-header">Data Album</div>
        <div class="card-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr class="table-primary">
                <th>ID</th>
                <th>Nama Album</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $userid = $_SESSION['userid'];
              $sql = mysqli_query($conn, "select * from album where userid='$userid'");
              while($data=mysqli_fetch_array($sql)) {

              ?>
              <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $data['namaalbum'] ?></td>
                <td><?php echo $data['deskripsi'] ?></td>
                <td><?php echo $data['tanggaldibuat'] ?></td>
                <td>
                  
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['albumid']?>">
                  <i class="bi bi-pencil-square"></i>
                  </button>

                  <div class="modal fade" id="edit<?php echo $data['albumid']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="../config/proses_album.php" method="POST" enctype="multipart/form-data">
                          <input type="hidden" name="albumid" value="<?php echo $data['albumid'] ?>">
                          <label class="form-label">Nama Album</label>
                          <input type="text" name="namaalbum" value="<?php echo $data['namaalbum'] ?>" class="form-control" required>
                          <label class="form-label">Deskripsi</label>
                          <textarea class="form-control" name="deskripsi" required> <?php echo $data['deskripsi']; ?> 
                          </textarea>
                        
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $data['albumid']?>">
                  <i class="bi bi-trash3-fill"></i>
                  </button>
                  <div class="modal fade" id="hapus<?php echo $data['albumid']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="../config/proses_album.php" method="POST">
                          <input type="hidden" name="albumid" value="<?php echo $data['albumid']?>">
                          Apakah anda yakin ingin menghapus <strong><?php echo $data['namaalbum']?></strong> ?
                        
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="hapus" class="btn btn-primary"><i class="bi bi-check-lg"></i></button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                </td>
              </tr>
              <?php  } ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>



<footer class="d-flex justify-content-center border-top mt-3 bg-secondary text-white fixed-bottom">
    <p>&copy; UKK RPL 2024 | Siti Eliyani</p>
</footer>
 
<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>
</html>