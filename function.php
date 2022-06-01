<?php 
session_start();
//membuat koneksi ke database
$conn = mysqli_connect("localhost","root","","stokbarang");
//cek koneksi database
// if($conn){
//     echo'berhasil';
// }

//menambah barang baru
if(isset($_POST['addnewBarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    $addtotable = mysqli_query($conn,"INSERT INTO stock (namabarang,deskripsi,stock) VALUES('$namabarang','$deskripsi','$stock')");
    if($addtotable){
        header('location:index.php');
    }else{
        echo'Gagal Menambahkan Barang';
        header('location:index.php');
    }
}


?>