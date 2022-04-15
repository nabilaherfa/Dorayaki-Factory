<?php session_start(); /* Starts the session */
    $is_admin = $_COOKIE["is_admin"];
    $uname = $_COOKIE["user"];

    class MyDB extends SQLite3 {
        function __construct() {
            $this->open('data.db');
        }
    }
    $db = new MyDB();

    // Mendapatkan id dari param
    $id = (int)$_GET['id'];

    // Mendapatkan data dari dorayaki dengan id tertentu
    $sql_data = $db->query("SELECT * FROM dorayaki WHERE id_dor = $id");
    while ($row = $sql_data->fetchArray(SQLITE3_ASSOC) ) {
        $nama = $row['nama'];
        $desc = $row['deskripsi'];
        $price = $row['harga'];
        $gambar = base64_encode($row['thumbnail']);
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

    // Menghapus dorayaki dengan id tertentu
    if (isset($_POST['delete'])) {
        $sql_delete = $db->exec("DELETE FROM dorayaki WHERE id_dor = $id");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/styles.css" />
    <link rel="stylesheet" href="./styles/detail.css">
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
            </div>

            <div class="list-btn">
                <?php if ($is_admin) : ?>
                    <a class="btn" href="ubah-stok.php?id=<?php echo $id ?>">Ubah Stok</a>
                    <a class="btn" href="#popup-delete">Delete</a>
                <?php else : ?>
                    <a class="btn" href="ubah-stok.php?id=<?php echo $id ?>">Beli</a>
                <?php endif; ?>
            </div>

            <div id="popup-delete" class="overlay">
                <div class="popup">
                    <h3>Kamu yakin ingin menghapus?</h3>
                    <a class="close" href="#">&times;</a>
                    <div class="content">
                        Dorayaki <?php echo $nama ?> akan terhapus dari database secara permanen
                    </div>
                    <form method="POST" action="detail.php?id=<?php echo $id ?>">
                        <input type="submit" class="btn" name="delete" />
                        <a class="btn" href="#">Batalkan</a>
                    </form>
                </div>
            </div>
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