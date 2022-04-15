<?php session_start();

    $uname = $_COOKIE["user"];
    $is_admin = $_COOKIE["is_admin"];

    class MyDB extends SQLite3 {
        function __construct() {
            $this->open('data.db');
        }
    }
    $db = new MyDB();


    if (isset($_POST['nama_dorayaki'])){
        $namaa = $_POST['nama_dorayaki'];
        $deskripsii = $_POST['deskripsi'];
        $hargaa = (int)$_POST['harga'];
        $thumbnaill = $_POST['thumbnail'];
        $stokk = (int)$_POST['stok'];
        $sql_inserthist_admin = $db->exec("INSERT INTO dorayaki (nama, deskripsi, harga, thumbnail, stok) VALUES ('$namaa', '$deskripsii','$hargaa', '$thumbnaill', '$stokk')");
    }

    $jsonobj = '{"1": "Dorayaki 1", "2": "Dorayaki 2", "3": "Dorayaki 3"}';
    
    $obj = json_decode($jsonobj);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./styles/penambahan.css" />
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
                <a href="./searching.php">Search Dorayaki</a>
                <a href="./logout.php">Log Out</a>
                <a class="active_link" href="./dashboard.php">Dashboard</a>
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

                <div class="container">
                    <form method="POST">
                        <div class="row">
                        <div class="col-25">
                        <label for="fname">Nama</label>
                            </div>
                        <div class="col-75">
                            <!-- <input type="text" name="nama_dorayaki" placeholder="Nama Dorayaki.."> -->
                            <select id="nama_dorayaki" name="nama_dorayaki">
                                <?php foreach($obj as $key => $value) { ?>
                                    <option value="<?php echo $value ?>"><?php echo $value ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-25">
                            <label for="lname">Deskripsi</label>
                        </div>
                        <div class="col-75">
                            <input type="text" name="deskripsi" placeholder="Deskripsi..">
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-25">
                            <label for="lname">Harga</label>
                        </div>
                        <div class="col-75">
                            <input type="text" name="harga" placeholder="Harga..">
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="lname">Thumbnail</label>
                            </div>
                            <div class="col-75">
                                <input type="file" name="thumbnail" placeholder="Thumbnail..">
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-25">
                            <label for="lname">Stok Awal</label>
                        </div>
                        <div class="col-75">
                            <input type="text" name="stok" placeholder="Stok Awal..">
                        </div>
                        </div>
                        <div class="row">
                            <input type="submit" name="submit" value="Submit">
                        </div>
                    </form>
                </div>
                <!-- CHARTS ENDS HERE -->
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
                <div class="sidebar__link active_menu_link">
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
                <div class="sidebar__link active_menu_link">
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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="script.js"></script>
</body>

</html>