<?php
session_start();
include 'koneksi.php';

$fotoid=$_POST['fotoid'];
$userid=$_SESSION['userid'];
$isikomentar=$_POST['isikomentar'];
$tanggalkomentar=date("Y-m-d");

$query=mysqli_query($conn, "insert into komentarfoto values('','$fotoid', '$userid','$isikomentar','$tanggalkomentar')");

echo "<script>
location.href='../admin/index.php';
</script>";

if (isset($_POST['hapus'])) {
    $userid = $_POST['userid'];
    $isikomentar=$_POST['isikomentar'];
    
  
    $sql = mysqli_query($conn, "delete from komentarfoto where userid='$userid'");
  
    echo "<script>
          alert('Data Berhasil Dihapus!');
          location.href='../admin/index.php';
          </script>";
  
    
  
  }

  ?>