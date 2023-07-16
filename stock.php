<?php

require 'ceklogin.php';
$h1 = mysqli_query($c, "select * from produk");
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
    <title>STOCK BARANG</title>
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
                            </a </a <div>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                    </div>
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
                                <div class="card-body">JUMLAH BARANG :
                                    <? $h2 ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-info mb-4" data-toggle="modal" data-target="#myModal">
                        TAMBAH BARANG BARU
                    </button>

                    <div </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DATA BARANG
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>nama produk</th>
                                        <th>deskripsi</th>
                                        <th>harga</th>
                                        <th>stock</th>
                                        <th>aksi</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $get = mysqli_query($c, "select * from produk");
                                    $i = 1;

                                    while ($p = mysqli_fetch_array($get)) {
                                        $namaproduk = $p['namaproduk'];
                                        $deskripsi = $p['deskripsi'];
                                        $harga = $p['harga'];
                                        $stock = $p['stock'];
                                        $idproduk = $p['idproduk'];

                                        ?>
                                        <tr>
                                            <td>
                                                <?= $i++; ?>
                                            </td>
                                            <td>
                                                <?= $namaproduk; ?>
                                            </td>
                                            <td>
                                                <?= $deskripsi; ?>
                                            </td>
                                            <td>Rp
                                                <?= number_format($harga); ?>
                                            </td>
                                            <td>
                                                <?= $stock; ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#edit<?=$idproduk; ?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#delete<?=$idproduk; ?>">
                                                    delete
                                                </button>
                                                
                                            </td>
                                        </tr>
                                        <!--  Modal edit-->
                                        <div class="modal fade" id="edit<?=$idproduk;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Ubah <?= $namaproduk; ?></h4>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <input type="text" name="namaproduk" class="form-control"
                                                                placeholder="nama produk" value="<?=$namaproduk;?>">
                                                            <input type="text" name="deskripsi" class="form-control mt-2"
                                                                placeholder="deskripsi" value="<?=$deskripsi; ?>">
                                                            <input type="num" name="harga" class="form-control mt-2"
                                                                placeholder="harga produk" value="<?=$harga;?>">
                                                            <input type="hidden" name="idp" value="<?=$idproduk;?>">
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success"
                                                                name="editbarang">submit</button>
                                                            <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                        <!--  Modal delete-->
                                        <div class="modal fade" id="delete<?=$idproduk;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus <?= $namaproduk; ?></h4>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menghapus barang ini?
                                                            <input type="hidden" name="idp" value="<?=$idproduk;?>">

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success"
                                                                name="hapusbarang">submit</button>
                                                            <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>




                                        <?php
                                    };

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
                <h4 class="modal-title">TAMBAH BARANG BARU</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form method="post">
                <div class="modal-body">
                    <input type="text" name="namaproduk" class="form-control" placeholder="nama produk">
                    <input type="text" name="deskripsi" class="form-control mt-2" placeholder="deskripsi">
                    <input type="num" name="stock" class="form-control mt-2" placeholder="stock awal">
                    <input type="num" name="harga" class="form-control mt-2" placeholder="harga awal">
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="tambahbarang">submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>


</html>