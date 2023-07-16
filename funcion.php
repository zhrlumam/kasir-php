<?php
session_start();

//bikin koneksi
$c = mysqli_connect('localhost', 'root', '', 'kasir');

//login
if (isset($_POST['login'])) {
    //variabel
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = mysqli_query($c, "SELECT * FROM user WHERE username='$username' and password='$password'");
    $hitung = mysqli_num_rows($check);

    if ($hitung) {
        //jika datanya ditemukan berhasil login
        $_SESSION['login'] = 'true';
        header('location:index.php');
    } else {
        //jika data tidak di temukan
        echo '
        <script>alert("username atau password salah");
        window.location.href ="login.php"
        </script>
        ';
    }
}
//tambah barang
if (isset($_POST['tambahbarang'])) {
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];

    $insert = mysqli_query($c, "insert into produk (namaproduk,deskripsi,harga,stock) values ('$namaproduk','$deskripsi','$harga','$stock')");

    if ($insert) {
        header('location:stock.php');
    } else {
        echo '
        <script>alert("gagal menambah barang baru");
        window.location.href="stock.php"
        </script>
        ';

    }
}
;
//tamba pelanggan
if (isset($_POST['tambahpelanggan'])) {
    $namapelanggan = $_POST['namapelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];


    $insert = mysqli_query($c, "insert into pelanggan (namapelanggan,notelp,alamat) values ('$namapelanggan','$notelp','$alamat')");

    if ($insert) {
        header('location:pelanggan.php');
    } else {
        echo '
        <script>alert("gagal menambah pelanggan baru");
        window.location.href="pelanggan.php"
        </script>
        ';

    }
}
//tambah pesanan
if (isset($_POST['tambahpesanan'])) {
    $idpelanggan = $_POST['idpelanggan'];

    $insert = mysqli_query($c, "insert into pesanan (idpelanggan) values ('$idpelanggan')");

    if ($insert) {
        header('location:index.php');
    } else {
        echo '
        <script>alert("gagal menambah barang baru");
        window.location.href="index.php"
        </script>
        ';

    }
}
;
//adproduk di pilih di pesanan
if (isset($_POST['addproduk'])) {
    $idproduk = $_POST['idproduk'];
    $idp = $_POST['idp'];
    $qty = $_POST['qty']; //jumlah

    //hitung
    $hitung1 = mysqli_query($c, "select * from produk where idproduk='$idproduk'");
    $hitung2 = mysqli_fetch_array($hitung1);
    $stocksekarang = $hitung2['stock'];


    if ($stocksekarang >= $qty) {

        $selisih = $stocksekarang = $qty;

        $insert = mysqli_query($c, "insert into detailpesanan (idpesanan,idproduk,qty) values ('$idp','$idproduk','$qty')");
        $update = mysqli_query($c, "update produk set stock ='$selisih'where idproduk='$idproduk'");

        if ($insert && $update) {
            header('location:view.php?idp=' . $idp);
        } else {
            echo '
            <script>alert("gagal menambah barang baru");
            window.location.href="view.php=' . $idp . '"
            </script>
            ';
        }
    } else {
        echo '
        <script>alert("stock tidak cukup");
        window.location.href="view.php?idp=' . $idp . '"
        </script>
        ';
    }

}
//tambah barang masuk
if (isset($_POST['barangmasuk'])) {
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];

    $caritahu = mysqli_query($c, "select * from produk where idproduk='$idproduk'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $stocksekarang = $caritahu2['stock'];

    //hitung
    $newstock = $stocksekarang+$qty;


    $insert = mysqli_query($c, "insert into masuk (idproduk,qty) values ('$idproduk','$qty')");
    $updatetb = mysqli_query($c,"update produk set stock='$newstock' where idproduk='$idproduk'");

    if ($insert&&$updatetb) {
        header('location:masuk.php');
    } else {
        echo '
        <script>alert("gagal menambah barang baru");
        window.location.href="masuk.php"
        </script>
        ';

    }
}
//hapus produk pesanan
if (isset($_POST['hapusprodukpesanan'])) {
    $idp = $_POST['idp'];
    $idpr = $_POST['idpr'];
    $idorder = $_POST['idorder'];

    $cek1 = mysqli_query($c, "select * from detailpesanan where iddetailpesanan='$idp'");
    $cek2 = mysqli_fetch_array($cek1);
    $qtysekarang = $cek2['qty'];

    //cek stok skrg
    $cek3 = mysqli_query($c, "select * from produk where idproduk='$idpr'");
    $cek4 = mysqli_fetch_array($cek3);
    $stocksekarang = $cek4['stock'];

    $hitung = $stocksekarang + $qtysekarang;

    $update = mysqli_query($c, "update produk set stock='$hitung' where idproduk='$idpr'"); //update stock
    $hapus = mysqli_query($c, "delete from detailpesanan where idproduk='$idpr' and iddetailpesanan='$idp'");

    if ($update && $hapus) {
        header('location:view.php?idp=' . $idorder);

    } else {
        echo '
            <script>alert("gagal menghapus barang");
            window.location.href="view.php?idp=' . $idorder . '"
            </script>
            ';

    }

}

//edit barang
if (isset($_POST['editbarang'])) {
    $np = $_POST['namaproduk'];
    $desc = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $idp = $_POST['idp']; //idproduk

    $query = mysqli_query($c, "update produk set namaproduk='$np', deskripsi='$desc', harga='$harga' where idproduk='$idp' ");

    if ($query) {
        header('location:stock.php');
    } else {
        echo '
        <script>alert("gagal");
        window.location.href="stock.php?"
        </script>
        ';
    }
}

//hapus barang
if (isset($_POST['hapusbarang'])) {
    $idp = $_POST['idp'];

    $query = mysqli_query($c, "delete from produk where idproduk='$idp'");


    if ($query) {
        header('location:stock.php');
    } else {
        echo '
    <script>alert("gagal");
    window.location.href="stock.php?"
    </script>
    ';
    }
}

//edit pelanggan
if (isset($_POST['editpelanggan'])) {
    $np = $_POST['namapelanggan'];
    $nt = $_POST['notelp'];
    $a = $_POST['alamat'];
    $id = $_POST['idpl'];

    $query = mysqli_query($c, "update pelanggan set namapelanggan='$np', notelp='$nt', alamat='$a' where idpelanggan='$id' ");

    if ($query) {
        header('location:pelanggan.php');
    } else {
        echo '
        <script>alert("gagal");
        window.location.href="pelanggan.php?"
        </script>
        ';
    }

}

//hapus pelanggan
if (isset($_POST['hapuspelanggan'])) {
    $idpl = $_POST['idpl'];

    $query = mysqli_query($c, "delete from pelanggan where idpelanggan='$idpl'");
    if ($query) {
        header('location:pelanggan.php');
    } else {
        echo '
        <script>alert("gagal");
        window.location.href="pelanggan.php?"
        </script>
        ';
    }
}

//mengubah barang masuk
if (isset($_POST['editdatabarangmasuk'])) {
    $qty = $_POST['qty'];
    $idm = $_POST['idm'];//id masuk
    $idp = $_POST['idp'];

    // cari tau qty skrg brp
    $caritahu = mysqli_query($c, "select * from masuk where idmasuk='$idm'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];


    //cari tahu stock
    $caristock = mysqli_query($c,"select * from produk where idproduk='$idp'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    if ($qty >= $qtysekarang) {
        // kalau lebih besar
        // hitung selisih
        $selisih = $qty-$qtysekarang;
        $newstock = $stocksekarang+$selisih;

        $query1 = mysqli_query($c, "update masuk set qty='$qty' where idmasuk='$idm'");
        $query2 = mysqli_query($c, "update produk set stock='$newstock' where idproduk='$idp'");


        if ($query1&&$query2) {
            header('location:masuk.php');
        } else {
            echo '
            <script>alert("gagal");
            window.location.href="masuk.php?"
            </script>
            ';
        }
    
    
} else {
    //kalau lebih kecil
    //hitung selisih
    $selisih = $qtysekarang-$qty; 
    $newstock = $stocksekarang-$selisih;

    $query1 = mysqli_query($c,"update masuk set qty='$qty' where idmasuk='$idm'");    
    $query2 = mysqli_query($c, "update produk set stock='$newstock' where idproduk='$idp'");

    if($query1&&$query2){
        header('location:masuk.php');
    }else{
        echo '
        <script>alert("gagal");
        window.location.href="masuk.php?"
        </script>
        ';
    }
  }
}


//hapus data barang masuk
if (isset($_POST['hapusdatabarangmasuk'])) {
    $idm = $_POST['idm'];
    $idp = $_POST['idp'];

    $caritahu = mysqli_query($c, "select * from masuk where idmasuk='$idm'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];


    //cari tahu stock
    $caristock = mysqli_query($c,"select * from produk where idproduk='$idp'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

  
    $newstock = $stocksekarang-$qtysekarang;

    $query1 = mysqli_query($c,"delete from masuk where idmasuk='$idm'");    
    $query2 = mysqli_query($c, "update produk set stock='$newstock' where idproduk='$idp'");

    if($query1&&$query2){
        header('location:masuk.php');
    }else{
        echo '
        <script>alert("gagal");
        window.location.href="masuk.php?"
        </script>
        ';
    }

}
//hapus order
if (isset($_POST['hapusorder'])) {
    $ido = $_POST['ido'];//id order

    $cekdata = mysqli_query($c,"select * from detailpesanan dp where idpesanan='$ido'");

    while($ok=mysqli_fetch_array($cekdata)){
        //balikin stock
        $qty = $ok['$qty'];
        $idproduk = $ok['idproduk'];
        $iddp = $ok['iddetailpesanan'];

          //cari tahu stock
    $caristock = mysqli_query($c,"select * from produk where idproduk='$idproduk'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    $newstock = $stocksekarang+$qty;

    $queryupdate = mysqli_query($c, "update produk set stock='$newstock' where idproduk='$idproduk'");

        //hapus data
$querydelete = mysqli_query($c,"delete from detailpesanan where iddetailpesanan='$iddp'");
       

    }

    $query = mysqli_query($c, "delete from pesanan where idorder='$ido'");
    if ($queryupdate && $querydelete && $query) {
        header('location:index.php');
    } else {
        echo '
        <script>alert("gagal");
        window.location.href="index.php?"
        </script>
        ';
    }
}

//mengubah detail pesanan
if (isset($_POST['editdetailpesanan'])) {
    $qty = $_POST['qty'];
    $iddp = $_POST['iddp'];//id masuk
    $idpr = $_POST['idpr'];
    $idp = $_POST['idp'];

    // cari tau qty skrg brp
    $caritahu = mysqli_query($c, "select * from detailpesanan where iddetailpesanan='$iddp'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];


    //cari tahu stock
    $caristock = mysqli_query($c,"select * from produk where idproduk='$idpr'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    if ($qty >= $qtysekarang) {
        // kalau lebih besar
        // hitung selisih
        $selisih = $qty-$qtysekarang;
        $newstock = $stocksekarang-$selisih;

        $query1 = mysqli_query($c, "update detailpesanan set qty='$qty' where iddetailpesanan='$iddp'");
        $query2 = mysqli_query($c, "update produk set stock='$newstock' where idproduk='$idpr'");


        if ($query1&&$query2) {
            header('location:view.php?idp='.$idp);
        } else {
            echo '
            <script>alert("gagal");
            window.location.href="view.php?idp='.$idp.'"
            </script>
            ';
        }
    
    
} else {
    //kalau lebih kecil
    //hitung selisih
    $selisih = $qtysekarang-$qty; 
    $newstock = $stocksekarang+$selisih;

    $query1 = mysqli_query($c,"update detailpesanan set qty='$qty' where iddetailpesanan='$iddp'");    
    $query2 = mysqli_query($c, "update produk set stock='$newstock' where idproduk='$idpr'");

    if($query1&&$query2){
        header('location:view.php?idp='.$idp);
    }else{
        echo '
        <script>alert("gagal");
        window.location.href="view.php?idp='.$idp.'"
        </script>
        ';
    }
  }
}
?>