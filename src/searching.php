<?php session_start(); /* Starts the session */
    class MyDB extends SQLite3 {
        function __construct() {
            $this->open('data.db');
        }
    }
    $db = new MyDB();
    $uname = $_COOKIE["user"];
    $is_admin = $_COOKIE["is_admin"];



    if (isset($_POST['pencarian'])) {
        $keyword = $_POST['pencarian'];
        $sql_data = $db->query("SELECT * FROM dorayaki WHERE nama LIKE '%$keyword%'");
    } else {
        $keyword = "";
        $sql_data = $db->query("SELECT * FROM dorayaki WHERE nama LIKE '%$keyword%'");
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./styles/searching.css" />
    <title>Doremonangis</title>
</head>

<body id="body">
    <div class="container">
        <nav class="navbar">
            <div class="nav_icon" onclick="toggleSidebar()">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </div>
            <div class="navbar__left">
            <?php if ($is_admin) : ?>
                <a class="active_link" href="./penambahan.php">Add Dorayaki</a>
                <a href="./logout.php">Log Out</a>
                <a href="./dashboard.php">Dashboard</a>
            <?php else : ?>
                <a class="active_link" href="./searching.php">Search Dorayaki</a>
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
            <div class="main__container">
                <!-- MAIN TITLE STARTS HERE -->

                <div class="main__title">
                    <img src="assets/hello.svg" alt="" />
                    <div class="main__greeting">
                        <h1>Hello Doraemon</h1>
                        <p>Welcome to your admin dashboard</p>
                    </div>
                </div>

                <!-- MAIN TITLE ENDS HERE -->
                <!-- TABLE STARTS HERE -->
                <form method="POST">
                    <div class="topnav">
                        <input type="text" name="pencarian" placeholder="Search..">
                    </div>
                    <div class="row">
                        <input type="submit" name="submit" value="Submit">
                    </div>
                </form>
                <div class="charts">
                    <div class="charts__left">
                        <div class="charts__left__title">
                            <div class="col-div-8">
                                <div class="box-8">
                                    <div class="content-box">
                                        <p>Hasil Pencarian Dorayaki </p>
                                        <br/>
                                        <table id="myTable">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Dorayaki</th>
                                            <th>Deskripsi</th>
                                            <th>Harga</th>
                                            <th>Thumbnail</th>
                                            <th>Stok</th>
                                        </tr>
                                        <?php while ($row = $sql_data->fetchArray(SQLITE3_ASSOC) ) { ?>
                                            <?php $nama = $row['nama']; ?>
                                            <?php $id_dorayaki = $row['id_dor']; ?>
                                            <?php $deskripsi = $row['deskripsi']; ?>
                                            <?php $harga = $row['harga']; ?>
                                            <?php $thumbnail = $row['thumbnail']; ?>
                                            <?php $stok = $row['stok']; ?>

                                            <tr>
                                                <td><?php echo $id_dorayaki?></td>
                                                <td><a href="detail.php?id=<?php echo $id_dorayaki ?>"><?php echo $nama?></a></td>
                                                <td><?php echo $deskripsi?></td>
                                                <td><?php echo $harga?></td>
                                                <td><?php echo $thumbnail?></td>
                                                <td><?php echo $stok?></td>
                                            </tr>
                                        <?php } ?>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- TABLE ENDS HERE -->
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
                <div class="sidebar__link active_menu_link">
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
                <div class="sidebar__link active_menu_link">
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
