<?php 
session_start();
//membuat koneksi ke database
$conn = mysqli_connect("localhost","root","","stokbarang");
//cek koneksi database
// if($conn){
//     echo'berhasil';
// }

//menambah barang baru
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    $addtotable = mysqli_query($conn,"INSERT INTO stock (namabarang,deskripsi,stock) VALUES('$namabarang','$deskripsi','$stock')");
    if($addtotable){
        header('location:index.php');
    }
    else{
        echo'Gagal Menambahkan Barang';
        header('location:index.php');
    }
}

//Menambah barang masuk
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn,"SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);
    
    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;

    $addtomasuk = mysqli_query($conn,"INSERT INTO masuk (idbarang, keterangan, qty) VALUES('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn,"UPDATE stock SET stock='$tambahkanstocksekarangdenganquantity' WHERE idbarang='$barangnya'");
    if($addtomasuk && $updatestockmasuk){
        header('location:masuk.php');
    }
    else{
        echo'Gagal Menambahkan Barang';
        header('location:masuk.php');
    }  
}

//Menambah barang keluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn,"SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);
    
    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;

    $addtomasuk = mysqli_query($conn,"INSERT INTO keluar (idbarang, penerima, qty) VALUES('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn,"UPDATE stock SET stock='$tambahkanstocksekarangdenganquantity' WHERE idbarang='$barangnya'");
    if($addtomasuk && $updatestockmasuk){
        header('location:keluar.php');
    }
    else{
        echo'Gagal Menambahkan Barang';
        header('location:keluar.php');
    }  
}
?>