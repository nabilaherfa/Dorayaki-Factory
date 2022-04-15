<?php session_start(); /* Starts the session */
    $uname = $_COOKIE["user"];
    $is_admin = $_COOKIE["is_admin"];

    class MyDB extends SQLite3 {
        function __construct() {
            $this->open('data.db');
        }
    }
    $db = new MyDB();

    // Mendapatkan id dari param
    $id = (int)$_GET['id'];

    // Mendapatkan stock awal
    $sql_data = $db->query("SELECT stok FROM dorayaki WHERE id_dor = $id");
        while ($row = $sql_data->fetchArray(SQLITE3_ASSOC) ) {
            $stock = $row['stok'];
    }

    // if (isset($_POST['stok_baru']) && $_POST['stok_baru'] != 0) {
    //     $stok_input = (int)$_POST['stok_baru'];

    //     if ($is_admin) {
    //         $beda_stock = $stok_input - $stock;

    //         // Mengupdate jumlah stok setelah edit & nambah ke table history - ADMIN
    //         if ($beda_stock != 0) {
    //             $sql_updatestock_admin = $db->exec("UPDATE dorayaki SET stok = $stok_input WHERE id_dor = $id");
    //             $sql_inserthist_admin = $db->exec("INSERT INTO add_history (username, id_dor, add_qty, add_time) VALUES ('$uname', $id, $beda_stock, datetime('now','localtime'))");
    //         }
    //     }
    // }

    if (isset($_POST['beli_berapa'])) {
        if (!$is_admin) {
            $beli_berapa = (int)$_POST['beli_berapa'];
            $stock_sisa = $stock - $beli_berapa;

            if ($beli_berapa <= $stock && $beli_berapa > 0) {
                // Mengupdate jumlah stok setelah beli & nambah ke table history & nambah ke table pembelian - PENGGUNA
                $sql_updatestock_user = $db->exec("UPDATE dorayaki SET stok = $stock_sisa WHERE id_dor = $id");

                $sql_inserthist_user = $db->exec("INSERT INTO buy_history (username, buy_time) VALUES ('$uname', datetime('now','localtime'))");
                $sql_insertbuy_user = $db->exec("INSERT INTO buy_qty (id_buy, id_dor, qty) VALUES ((SELECT MAX(id_buy) FROM buy_history), $id, $beli_berapa)");
            }
        }
    }

    // Mendapatkan data dari dorayaki dengan id tertentu
    $sql_data = $db->query("SELECT * FROM dorayaki WHERE id_dor = $id");
        while ($row = $sql_data->fetchArray(SQLITE3_ASSOC) ) {
            $nama = $row['nama'];
            $desc = $row['deskripsi'];
            $price = $row['harga'];
            $gambar = $row['thumbnail'];
            $stock = $row['stok'];
    }

    // Mendapatkan data terjual dari dorayaki
    $sql_terjual = $db->query("SELECT SUM(qty) AS terjual FROM buy_qty WHERE id_dor = $id");
    while ($row = $sql_terjual->fetchArray(SQLITE3_ASSOC) ) {
        $terjual_dor = $row['terjual'];
    }
    if (!isset($terjual_dor)) {
        $terjual_dor = 0;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/styles.css" />
    <link rel="stylesheet" href="./styles/ubah-stok.css">
    <script src="./script/ubah-stok.js" defer></script>
</head>

<body id="body">
    <div class="container">
        <nav class="navbar">
            <div class="nav_icon" onclick="toggleSidebar()">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </div>
            <div class="navbar__left">
            <?php if ($is_admin) : ?>
                <a href="./penambahan.php">Add Dorayaki</a>
                <a href="./logout.php">Log Out</a>
                <a href="./dashboard.php">Dashboard</a>
            <?php else : ?>
                <a href="./searching.php">Search Dorayaki</a>
                <a href="./logout.php">Log Out</a>
                <a href="./dashboard.php">Dashboard</a>
            <?php endif; ?>
            </div>
            <div class="navbar__right">
                <a href="#">
                    <img width="30" src="assets/avatar.svg" alt="" />
                </a>
                <p><?php echo $uname?></p>
            </div>
        </nav>

        <main>
            <form method="POST">
                <div class="row">
                    <div class="detail">
                        <div class="detail-img">
                            <img src="dorayaki-img.jpeg">
                        </div>
                        <div class="detail-content">
                            <h2 class="detail-title"><?php echo $nama ?></h2>
                            <p class="detail-desc"><?php echo $desc ?></p>
                            <h3 class="detail-price">Rp<?php echo $price ?></h3>
                            <p class="detail-more">Tersisa <?php echo $stock ?> Stok | <?php echo $terjual_dor ?> Terjual</p>
                        </div>
                        <?php if ($is_admin) : ?>
                                <div class="counter counter-admin">
                                    <p id="errormsg"></p>
                                    <a onclick="changeStockAdmin(-1)">-</a>
                                    <input id="nstockadmin" type="number" name="stok_baru" value=0 min=0 required />
                                    <a onclick="changeStockAdmin(1)">+</a>
                                    <button class="btn" type="submit">Request</button>
                                </div>
                            </form>
                        <?php else : ?>
                            <div class="counter">
                                <p id="errormsg"></p>
                                <a onclick="changeStock(-1, <?php echo $stock ?>, <?php echo $price ?>)">-</a>
                                <input id="nstock" type="number" value=0 name="beli_berapa" onchange="autoChangeStock(<?php echo $stock ?>, <?php echo $price ?>)" min=0 />
                                <a onclick="changeStock(1, <?php echo $stock ?>, <?php echo $price ?>)">+</a>
                            </div>                
                        <?php endif; ?>
                    </div>

                    <?php if (!$is_admin) : ?>
                        <div class="checkout">
                            <form method="POST">
                                <h3>Checkout</h3><br>
                                <h5>Nama Dorayaki</h5>
                                <div class="order-detail">
                                    <div class="order-price">
                                        <p>Rp<?php echo $price ?><p>
                                    </div>
                                    <div class="order-quantity">
                                        <p id="nstockfinal"></p>
                                    </div>
                                </div>
                                <br><br>
                                <div class="divider">
                                    <h3>Total Pembayaran</h3>
                                </div>
                                <div class="order-detail">
                                    <div class="order-price">
                                        <p id="finalprice">Rp0<p>
                                    </div>
                                    <div class="order-quantity">
                                        <button class="btn" type="submit">Beli</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                </div>
            </form>
        </main>

        <div id="sidebar">
            <div class="sidebar__title">
                <div class="sidebar__img">
                    <img src="assets/logo.png" alt="logo" />
                    <h1>Doremonangis</h1>
                </div>
                <i onclick="closeSidebar()" class="fa fa-times" id="sidebarIcon" aria-hidden="true"></i>
            </div>
            <?php if ($is_admin) : ?>
            <div class="sidebar__menu">
                <div class="sidebar__link">
                    <i class="fa fa-home"></i>
                    <a href="./dashboard.php">Dashboard</a>
                </div>
                <h2>MANAGE DORAYAKI</h2>
                <div class="sidebar__link">
                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                    <a href="./penambahan.php">Add Dorayaki</a>
                </div>
                <div class="sidebar__link">
                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                    <a href="./searching.php">Search Dorayaki</a>
                </div>
                <div class="sidebar__link">
                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                    <a href="./ubah-stok-riwayat.php">Riwayat Stok</a>
                </div>
                <div class="sidebar__logout">
                    <i class="fa fa-power-off"></i>
                    <a href="./logout.php">Log out</a>
                </div>
            </div>
            <?php else : ?>
            <div class="sidebar__menu">
                <div class="sidebar__link">
                    <i class="fa fa-home"></i>
                    <a href="./dashboard.php">Dashboard</a>
                </div>
                <h2>MANAGE DORAYAKI</h2>
                <div class="sidebar__link">
                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                    <a href="./searching.php">Search Dorayaki</a>
                </div>
                <div class="sidebar__link">
                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                    <a href="./ubah-stok-riwayat.php">Riwayat Stok</a>
                </div>

                <div class="sidebar__logout">
                    <i class="fa fa-power-off"></i>
                    <a href="./logout.php">Log out</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>