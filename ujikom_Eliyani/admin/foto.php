<?php
include "../config/koneksi.php";
session_start();
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
<nav class="navbar navbar-expand-lg bg-body-tertiary bg-info text-dark border-bottom">
  <div class="container">
    <a class="navbar-brand text-white" href="index.php">Website Galerry Foto</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
    <div class="navbar-nav me-auto"></div>
    <ul class="navbar-nav">
       <li class="nav-item"><a href="home.php" class="nav-link text-white"><i class="bi bi-house-door-fill">Home</i></a></li>
       <a href="album.php" class="nav-link text-white"><i class="bi bi-journal-album">Album</i></a>
       <a href="foto.php" class="nav-link text-dark"><i class="bi bi-file-image">Foto</i></a>
        </div>
        </ul>
  </div>
  <a href="../config/proses_logout.php" class="btn btn-outline-danger m-1 text-white"><i class="bi bi-box-arrow-right"></i></a>
</nav>

<div class="container">
  <div class="row">
    <div class="col-md-4">
      <div class="card mt-2">
        <div class="card-header">Tambah Foto</div>
        <div class="card-body">
          <form action="../config/proses_foto.php" method="POST" enctype="multipart/form-data">
            <label class="form-label">Judul Foto</label>
            <input type="text" name="judulfoto" class="form-control" required>
            <label class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsifoto" required></textarea>
            <label class="form-label">Album</label>
            <select class="form-control" name="albumid" required>
            <?php
            $userid = $_SESSION['userid'];
            $sql_album = mysqli_query($conn, "select * from album where userid='$userid'");
            while($data_album=mysqli_fetch_array($sql_album)){ ?>
            <option value="<?php echo $data_album['albumid'] ?>"><?php echo $data_album['namaalbum'] ?></option>
            <?php  
            }
            ?>
            </select>
            
            <label class="form-label">File</label>
            <input type="file" class="form-control" name="lokasifile" required>
            <button type="submit" class="btn btn-primary mt-2" name="tambah">Tambah</button>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="card mt-2">
        <div class="card-header">Data Gallery Foto</div>
        <div class="card-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr class="table-primary">
                <th>ID</th>
                <th>Foto</th>
                <th>Judul Foto</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $userid = $_SESSION['userid'];
              $sql = mysqli_query($conn, "select * from foto where userid='$userid'");
              while($data=mysqli_fetch_array($sql)){

              ?>
              <tr>
                <td><?php echo $no++ ?></td>
                <td><img src="../assets/img/<?php echo $data['lokasifile']?>" width="100"></td>
                <td><?php echo $data['judulfoto'] ?></td>
                <td><?php echo $data['deskripsifoto'] ?></td>
                <td><?php echo $data['tanggalunggah'] ?></td>
                <td>
                  
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['fotoid']?>">
                  <i class="bi bi-pencil-square"></i>
                  </button>
                  <div class="modal fade" id="edit<?php echo $data['fotoid']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="../config/proses_foto.php" method="POST" enctype="multipart/form-data">
                          <input type="hidden" name="fotoid" value="<?php echo $data['fotoid']?>">
                          <label class="form-label">Judul Foto</label>
                          <input type="text" name="judulfoto" value="<?php echo $data['judulfoto']?>" class="form-control" required>
                          <label class="form-label">Deskripsi</label>
                          <textarea class="form-control" name="deskripsifoto" required><?php echo $data['deskripsifoto'];?> 
                          </textarea>
                          <label class="form-label">Album</label>
                          <select class="form-control" name="albumid">
                          <?php
                          $userid = $_SESSION['userid'];
                          $sql_album = mysqli_query($conn, "select * from album where userid='$userid'");
                          while($data_album=mysqli_fetch_array($sql_album)){ ?>
                          
                          <option <?php if($data_album['albumid']==$data['albumid']) {?> selected="selected" <?php } ?>  value="<?php echo $data_album['albumid'] ?>"><?php echo $data_album['namaalbum'] ?></option>
                          <?php  
                          }
                          ?>
                          </select>
                          <label class="form-label">Foto</label>
                          <div class="row">
                            <div class="col-md-4">
                            <img src="../assets/img/<?php echo $data['lokasifile']?>" width="100">
                            </div>
                            <div class="col-md-8">
                            <label class="form-label">Ganti File</label>
                            <input type="file" class="form-control" name="lokasifile">
                              
                            </div>
                          </div>
                          
                        
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $data['fotoid']?>">
                  <i class="bi bi-trash3-fill"></i>
                  </button>
                  <div class="modal fade" id="hapus<?php echo $data['fotoid']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="../config/proses_foto.php" method="POST">
                          <input type="hidden" name="fotoid" value="<?php echo $data['fotoid']?>">
                          Apakah anda yakin ingin menghapus <strong><?php echo $data['judulfoto']?></strong>?
                        
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="hapus" class="btn btn-primary">Hapus</button>
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



<footer class="d-flex justify-content-center border-top mt-3 bg-secondary fixed-bottom">
    <p>&copy; UKK RPL 2024 | Siti Eliyani</p>
</footer>
 
<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>
</html>