<?php session_start(); /* Starts the session */
    $user = $_COOKIE["user"];
    $is_admin = $_COOKIE["is_admin"];

    class MyDB extends SQLite3 {
        function __construct() {
            $this->open('data.db');
        }
    }
    $db = new MyDB();

    // Mendapatkan data dari dorayaki dengan id tertentu
    $data_admin = "SELECT username, id_dor, add_qty AS quan, add_time AS waktu FROM add_history";
    $data_user = "SELECT username, id_dor, qty AS quan, buy_time AS waktu FROM buy_qty NATURAL INNER JOIN buy_history";

    if (!$is_admin) {
        $sql_data = $db->query("$data_user WHERE username = '$user'");
    } else {
        $sql_data = $db->query("$data_admin UNION $data_user ORDER BY waktu");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/styles.css" />
    <link rel="stylesheet" href="./styles/ubah-stok-riwayat.css">
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
                <a class="active_link" href="./dashboard.php">Dashboard</a>
            <?php else : ?>
                <a href="./searching.php">Search Dorayaki</a>
                <a href="./logout.php">Log Out</a>
                <a class="active_link" href="./dashboard.php">Dashboard</a>
            <?php endif; ?>
            </div>
            <div class="navbar__right">
                <a href="#">
                    <img width="30" src="assets/avatar.svg" alt="" />
                </a>
                <p><?php echo $user?></p>
            </div>
        </nav>

        <main>
            <table id="riwayat">
                <tr>
                    <th>Nama Dorayaki</th>
                    <th>Jumlah Pengubahan</th>
                    <th>Total Harga</th>
                    <th>User</th>
                    <th>Waktu</th>
                </tr>
                <?php while ($row = $sql_data->fetchArray(SQLITE3_ASSOC) ) { ?>
                    <?php $uname = $row['username']; ?>
                    <?php $id_dorayaki = $row['id_dor']; ?>
                    <?php $qty = $row['quan']; ?>
                    <?php $time = $row['waktu']; ?>
                    <?php $is_user_admin = ($uname == "doraemon"); ?>

                    <?php $sql_dorayaki = $db->query("SELECT * FROM dorayaki WHERE id_dor = $id_dorayaki"); ?>

                    <?php if (empty($sql_dorayaki)) : ?>
                        <?php $dorayaki = "AAA"; ?>
                        <?php $price = "N/A"; ?>
                    <?php else : ?>
                        <?php while ($row1 = $sql_dorayaki->fetchArray(SQLITE3_ASSOC) ) { ?>
                            <?php $dorayaki = $row1['nama']; ?>
                            <?php $price = $is_user_admin ? "-" : "Rp" . $row1['harga'] * $qty; ?>
                            <?php } ?>
                    <?php endif; ?>
                    <tr>
                        <td>
                            <?php if (isset($dorayaki)) : ?>
                                <a href="detail.php?id=<?php echo $id_dorayaki ?>"><?php echo $dorayaki?></a>
                            <?php else : ?>
                                <?php echo "Undefined" ?>
                            <?php endif; ?>
                        </td>
                        <?php if ($is_user_admin) : ?>
                            <td><?php echo $qty > 0? "+" : "" ?><?php echo $qty?></td>
                        <?php else : ?>
                            <td>-<?php echo $qty?></td>
                        <?php endif; ?>
                        <?php if (isset($price)) : ?>
                            <td><?php echo $price?></td>
                        <?php else : ?>
                            <td><?php echo "Undefined" ?></td>
                        <?php endif; ?>
                        <td><?php echo $uname?></td>
                        <td><?php echo $time?></td>
                    </tr>
                <?php } ?>
            </table>
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
                <div class="sidebar__link active_menu_link">
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
                <div class="sidebar__link active_menu_link">
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