<?php
//mengaktifkan session php
session_start();

//menghapus semua session
session_destroy();
echo "<script>
alert('Logout Berhasil');
location.href='../index.php';
</script>";

?>
