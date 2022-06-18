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
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn,"SELECT * FROM stockbarang WHERE idbarang='$barangnya'");
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
    $idm = $_POST['idm'];
    $jenis = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    if($qty>$qtyskrng){
        $selisih = $qty-$qtyskrng;
        $kurangin = $stockskrng - $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn,"UPDATE masuk SET qty='$qty', keterangan='$jenis' WHERE idmasuk='$idm'");
            if($kurangistocknya&&$updatenya){
                header('location:masuk.php');
            }
            else{
                echo'Gagal Menambahkan Barang';
                header('location:masuk.php');
            } 
    }else{
        $selisih = $qtyskrng-$qty;
        $kurangin = $stockskrng + $selisih;

        $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn,"UPDATE masuk SET qty='$qty', keterangan='$jenis' WHERE idmasuk='$idm'");
            if($kurangistocknya&&$updatenya){
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
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn,"SELECT * FROM stock WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok-$qty;

    $update = mysqli_query($conn,"UPDATE stock SET stock ='$selisih' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"DELETE FROM masuk WHERE idmasuk='$idm'");
    if($update&&$hapusdata){
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
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn, "SELECT * FROM keluar WHERE idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    if($qty>$qtyskrng){
        $selisih = $qty-$qtyskrng;
        $kurangin = $stockskrng - $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn,"UPDATE keluar SET qty='$qty', penerima='$penerima' WHERE idkeluar='$idk'");
            if($kurangistocknya&&$updatenya){
                header('location:keluar.php');
            }
            else{
                echo'Gagal Menambahkan Barang';
                header('location:keluar.php');
            } 
    }else{
        $selisih = $qtyskrng-$qty;
        $kurangin = $stockskrng + $selisih;

        $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn,"UPDATE keluar SET qty='$qty', penerima='$penerima' WHERE idkeluar='$idk'");
            if($kurangistocknya&&$updatenya){
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
    $qty = $_POST['qty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn,"SELECT * FROM stock WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok+$qty;

    $update = mysqli_query($conn,"UPDATE stock SET stock ='$selisih' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"DELETE FROM keluar WHERE idkeluar='$idk'");
    if($update&&$hapusdata){
        header('location:keluar.php');
    }
    else{
        echo'Gagal Menghapus Barang';
        header('location:keluar.php');
    } 
}
?>