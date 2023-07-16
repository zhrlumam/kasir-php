<?php

require 'ceklogin.php';

//hitung pesanan
$h1 = mysqli_query($c, "select * from pesanan");
$h2 = mysqli_num_rows($h1);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>DATA PESANAN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">TOKO UMAM JAYA BANGET</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">MENU</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tshirt"></i></div>
                            ORDER
                        </a>
                        <a class="nav-link" href="stock.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-archive"></i></div>
                            STOCK BARANG
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-socks"></i></div>
                            BARANG MASUK
                            <a class="nav-link" href="pelanggan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-socks"></i></div>
                                KELOLA PELANGGAN
                            </a </a </a>
                    </div>
                    <a class="nav-link" href="logout.php">
                        Logout
                    </a>
                    </a>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">di buat di blangkon:</div>
                    MOCH ZUHRUL UMAM
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">DATA PESANAN</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">SELAMAT DATANG</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">JUMLAH:
                                    <?= $h2; ?>
                                </div>
                                <div>
                                    <a></a>
                                    <div><i></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div </div>
                    </div>
                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-info mb-4" data-toggle="modal" data-target="#myModal">
                        TAMBAH PESANAN BARU
                    </button>


                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DATA PESANAN
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>idpesanan</th>
                                        <th>tanggal</th>
                                        <th>Nama pelanggan</th>
                                        <th>jumlah</th>
                                        <th>aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $get = mysqli_query($c, "select * from pesanan p, pelanggan pl where p.idpelanggan=pl.idpelanggan");

                                    while ($p = mysqli_fetch_array($get)) {
                                        $idorder = $p['idorder'];
                                        $tanggal = $p['tanggal'];
                                        $namapelanggan = $p['namapelanggan'];
                                        $alamat = $p['alamat'];

                                        $hitungjumlah = mysqli_query($c, "select * from detailpesanan where idpesanan='$idorder'");
                                        $jumlah = mysqli_num_rows($hitungjumlah);

                                        ?>
                                        <tr>
                                            <td>
                                                <?= $idorder; ?>
                                            </td>
                                            <td>
                                                <?= $tanggal; ?>
                                            </td>
                                            <td>
                                                <?= $namapelanggan; ?> -
                                                <?= $alamat; ?>
                                            </td>
                                            <td>
                                                <?= $jumlah; ?>
                                            </td>
                                            <td><a href="view.php?idp=<?= $idorder; ?>" class="btn btn-primary"
                                                    target="blank">tampilkan</a> <button type="button"
                                                    class="btn btn-danger" data-toggle="modal"
                                                    data-target="#delete<?= $idorder; ?>">
                                                    delete
                                                </button>
                                    </td>
                                        </tr>

                                         <!--  Modal delete-->
                                         <div class="modal fade" id="delete<?=$idorder;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Data Pesanan</h4>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menghapus data Pesanan ini?
                                                            <input type="hidden" name="ido" value="<?=$idorder;?>">
                                                          

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success"
                                                                name="hapusorder">submit</button>
                                                            <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                    }


                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">TAMBAH PESANAN BARU</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form method="post">

                <div class="modal-body">
                    pilih pelanggan
                    <select name="idpelanggan" class="form-control">

                        <?php
                        $getpelanggan = mysqli_query($c, "select * from pelanggan");

                        while ($pl = mysqli_fetch_array($getpelanggan)) {
                            $idpelanggan = $pl['idpelanggan'];
                            $namapelanggan = $pl['namapelanggan'];
                            $alamat = $pl['alamat'];

                            ?>
                            <option value="<?= $idpelanggan; ?>"><?= $namapelanggan; ?> - <?= $alamat; ?></option>
                            <?php
                        }
                        ?>

                    </select>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="tambahpesanan">submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>

</html>