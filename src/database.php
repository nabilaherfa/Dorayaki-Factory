<?php
    class MyDB extends SQLite3 {
        function __construct() {
            $this->open('data.db');
        }
    }
    $db = new MyDB();

    // Cek udah buka database apa belom
    // if(!$db) {
    //     echo $db->lastErrorMsg();
    // } else {
    //     echo "Opened database successfully\n";
    // }

    $commands = [
        // uncomment kalau mau reset database
        // 'DROP TABLE user',
        // 'DROP TABLE dorayaki',
        // 'DROP TABLE buy_history',
        // 'DROP TABLE buy_qty',
        // 'DROP TABLE add_history',

        // tabel untuk daftar pengguna
        'CREATE TABLE IF NOT EXISTS user (
            username VARCHAR(100) UNIQUE NOT NULL,
            pass VARCHAR(255) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            is_admin BOOLEAN NOT NULL,
            PRIMARY KEY (username))',

        // tabel untuk daftar dorayaki
        'CREATE TABLE IF NOT EXISTS dorayaki (
            id_dor INTEGER PRIMARY KEY AUTOINCREMENT,
            nama VARCHAR(100) NOT NULL,
            deskripsi TEXT,
            harga INTEGER NOT NULL,
            thumbnail BLOB,
            stok INTEGER NOT NULL)',

        // tabel untuk riwayat pemesanan
        'CREATE TABLE IF NOT EXISTS buy_history (
            id_buy INTEGER PRIMARY KEY AUTOINCREMENT,
            username VARCHAR(100),
            buy_time TIMESTAMP NOT NULL,
            FOREIGN KEY (username) REFERENCES user(username))',
        
        // tabel tiap pemesanan apa aja yang dibeli
        'CREATE TABLE IF NOT EXISTS buy_qty (
            id_buy INTEGER,
            id_dor INTEGER,
            qty INTEGER NOT NULL,
            FOREIGN KEY (id_buy) REFERENCES buy_history(id_buy),
            FOREIGN KEY (id_dor) REFERENCES dorayaki(id_dor))',

        // tabel untuk riwayat penambahan stok
        'CREATE TABLE IF NOT EXISTS add_history (
            id_add INTEGER PRIMARY KEY AUTOINCREMENT,
            username VARCHAR(100),
            id_dor INTEGER,
            add_qty INTEGER NOT NULL,
            add_time TIMESTAMP NOT NULL,
            FOREIGN KEY (username) REFERENCES user(username),
            FOREIGN KEY (id_dor) REFERENCES dorayaki(id_dor))'
    ];

    foreach ($commands as $command) {
        $ret = $db->exec($command);
        // Cek kalo tabel udah dibuat/bisa diakses
        // if(!$ret){
        //     echo $db->lastErrorMsg();
        // } else {
        //     echo "Table created successfully\n";
        // }
    }

    // Insert
    // $t_pass = trim("admincakep");
    // $db->exec("INSERT INTO user (username, pass, email, is_admin) VALUES ('admincakep', '$t_pass', 'admincakep@gmail.com', TRUE)");
    // $db->exec("UPDATE user SET is_admin = TRUE WHERE username = 'doraemon'");
    // $db->exec("DELETE FROM add_history");
    // $db->exec("DELETE FROM buy_history");
    // $db->exec("DELETE FROM buy_qty");
    // $aaa = $db->exec("SELECT * FROM user");
    // echo $aaa;

    $ret = $db->query("SELECT * FROM dorayaki");
    // while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
    //     echo "ID = ". $row['id_dor'] . "\n";
    //     echo "nama = ". $row['nama'] ."\n";
    //     echo "deskripsi = ". $row['deskripsi'] ."\n";
    //     echo "harga = ".$row['harga'] ."\n\n";
    //     echo "thumbnail = ".$row['thumbnail'] ."\n\n";
    //     echo "stok = ".$row['stok'] ."\n\n";
    // }

    $db->close();

?>
