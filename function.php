<?php 
session_start();

//membuat koneksi ke database
$conn = mysqli_connect("localhost","root","","db_stockbarang");
//cek koneksi database
// if($conn){
//     echo'berhasil';
// }

//menambah stock barang
if(isset($_POST['addstockbarang'])){
    $kategori = $_POST['kategori'];
    $jenis = $_POST['jenis'];
    $merk = $_POST['merk'];
    $stock = $_POST['stock'];

    $addtotable = mysqli_query($conn,"INSERT INTO stockbarang (kategori,jenis,merk,stock) VALUES('$kategori','$jenis','$merk','$stock')");
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
    $jenisnya = $_POST['jenisnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn,"SELECT * FROM stockbarang WHERE idbarang='$jenisnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);
    
    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;

    $addtomasuk = mysqli_query($conn,"INSERT INTO barangmasuk (idbarang, penerima, qty) VALUES('$jenisnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn,"UPDATE stockbarang SET stock='$tambahkanstocksekarangdenganquantity' WHERE idbarang='$jenisnya'");
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
    $jenisnya = $_POST['jenisnya'];
    $pembeli= $_POST['pembeli'];
    $jumlah = $_POST['jumlah'];

    $cekstocksekarang = mysqli_query($conn,"SELECT * FROM stockbarang WHERE idbarang='$jenisnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);
    
    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$jumlah;

    $addtomasuk = mysqli_query($conn,"INSERT INTO barangkeluar (idbarang, pembeli, jumlah) VALUES('$jenisnya','$pembeli','$jumlah')");
    $updatestockmasuk = mysqli_query($conn,"UPDATE stockbarang SET stock='$tambahkanstocksekarangdenganquantity' WHERE idbarang='$jenisnya'");
    if($addtomasuk && $updatestockmasuk){
        header('location:keluar.php');
    }
    else{
        echo'Gagal Menambahkan Barang';
        header('location:keluar.php');
    }  
}

//Mengubah info stock barang
if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $kategori = $_POST['kategori'];
    $jenis = $_POST['jenis'];
    $merk = $_POST['merk'];
    $stock = $_POST['stock'];

    $update = mysqli_query($conn,"UPDATE stockbarang SET kategori='$kategori', jenis='$jenis', merk='$merk', stock='$stock' WHERE idbarang='$idb'");
    if($update){
        header('location:index.php');
    }
    else{
        echo'Gagal Menambahkan Barang';
        header('location:index.php');
    } 
}

//Menghapus barang dari stock
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "DELETE FROM stockbarang WHERE idbarang='$idb'");
    if($hapus){
        header('location:index.php');
    }
    else{
        echo'Gagal Menambahkan Barang';
        header('location:index.php');
    } 
}

//Mengubah data barang masuk
if(isset($_POST['updatebarangmasuk'])){
    $idb = $_POST['idb'];
    $idbm = $_POST['idbm'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stockbarang WHERE idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn, "SELECT * FROM barangmasuk WHERE idbarangmasuk='$idbm'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    if($qty>$qtyskrng){
        $selisih = $qty-$qtyskrng;
        $kurangin = $stockskrng - $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stockbarang SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn,"UPDATE barangmasuk SET qty='$qty', penerima='$penerima' WHERE idbarangmasuk='$idbm'");
            if($kurangistocknya && $updatenya){
                header('location:masuk.php');
            }
            else{
                echo'Gagal Menambahkan Barang';
                header('location:masuk.php');
            } 
    } else{
        $selisih = $qtyskrng+$qty;
        $kurangin = $stockskrng + $selisih;

        $kurangistocknya = mysqli_query($conn, "UPDATE stockbarang SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn,"UPDATE barangmasuk SET qty='$qty', penerima='$penerima' WHERE idbarangmasuk='$idbm'");
            if($kurangistocknya && $updatenya){
                header('location:masuk.php');
            }
            else{
                echo'Gagal Edit Barang';
                header('location:masuk.php');
            } 
    }
}

//Menghapus barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['qty'];
    $idbm = $_POST['idbm'];

    $getdatastock = mysqli_query($conn,"SELECT * FROM stockbarang WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok-$qty;

    $update = mysqli_query($conn,"UPDATE stockbarang SET stock ='$selisih' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"DELETE FROM barangmasuk WHERE idbarangmasuk='$idbm'");
    if($update && $hapusdata){
        header('location:masuk.php');
    }
    else{
        echo'Gagal Menghapus Barang';
        header('location:masuk.php');
    } 
}

//Mengubah data barang keluar
if(isset($_POST['updatebarangkeluar'])){
    $idb = $_POST['idb'];
    $idbk = $_POST['idbk'];
    $pembeli = $_POST['pembeli'];
    $jumlah = $_POST['jumlah'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stockbarang WHERE idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $jumlahskrng = mysqli_query($conn, "SELECT * FROM barangkeluar WHERE idkeluar='$idk'");
    $jumlahnya = mysqli_fetch_array($jumlahskrng);
    $jumlahskrng = $jumlahnya['qty'];

    if($jumlah>$jumlahskrng){
        $selisih = $jumlah - $jumlahskrng;
        $kurangin = $stockskrng - $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stockbarang SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn,"UPDATE barangkeluar SET jumlah='$jumlah', pembeli='$pembeli' WHERE idbarangkeluar='$idbk'");
            if($kurangistocknya && $updatenya){
                header('location:keluar.php');
            }
            else{
                echo'Gagal Menambahkan Barang';
                header('location:keluar.php');
            } 
    }else{
        $selisih = $jumlahskrng - $jumlah;
        $kurangin = $stockskrng + $selisih;

        $kurangistocknya = mysqli_query($conn, "UPDATE stockbarang SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn,"UPDATE barangkeluar SET jumlah='$jumlah', pembeli='$pembeli' WHERE idbarangkeluar='$idbk'");
            if($kurangistocknya && $updatenya){
                header('location:keluar.php');
            }
            else{
                echo'Gagal Edit Barang';
                header('location:keluar.php');
            } 
    }
}

//Menghapus barang keluar
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $jumlah = $_POST['jumlah'];
    $idbk = $_POST['idbk'];

    $getdatastock = mysqli_query($conn,"SELECT * FROM stockbarang WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok + $jumlah;

    $update = mysqli_query($conn,"UPDATE stockbarang SET stock ='$selisih' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"DELETE FROM barangkeluar WHERE idbarangkeluar='$idbk'");
    if($update && $hapusdata){
        header('location:keluar.php');
    }
    else{
        echo'Gagal Menghapus Barang';
        header('location:keluar.php');
    } 
}
?>