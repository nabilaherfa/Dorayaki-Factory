<?php
if(isset($_COOKIE["user"])  && $_COOKIE["is_admin"] !== true) {
    header("location: dashboard.php");
    exit;
}
elseif(isset($_COOKIE["user"])  && $_COOKIE["is_admin"] === true) {
    header("location: dashboard.php");
    exit;
}

include "database.php";
$db = new MyDB();
$username = $t_pass = "";
$username_err = $t_pass_err = $login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check empty fields
    if (empty(trim($_POST["username"]))) {
        $username_err = "Username is required.";
    }
    else {
        $username = trim($_POST["username"]);
    }
    if (empty(trim($_POST["password"]))) {
        $t_pass_err = "Password is required.";
    }
    else {
        $t_pass = trim($_POST["password"]);
    }

    // Validation
    if (empty($username_err) && empty($t_pass_err)) {
        $validate = $db->prepare('SELECT username, pass, is_admin FROM user WHERE username = :uname');
        $validate->bindValue(':uname', $username, SQLITE3_TEXT);
        $result = $validate->execute();

        $h_pass = "";
        while($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $h_pass = $row['pass'];
            $is_admin = $row['is_admin'];
        }

        if (empty($h_pass) || !password_verify($t_pass, $h_pass)) {
            $login_err = "Invalid username or password.";
        }
        else {
            setcookie("user", $username);
            setcookie("is_admin", $is_admin);
            if (!($is_admin)) {
                header("location: dashboard.php"); // disesuain
            }
            else {
                header("location: dashboard.php");
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/login.css">
</head>

<body>
    <main id="main-holder">
        <div id="login"><h1>Login</h1></div>
        <?php 
            if(!empty($login_err)){
                echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }        
        ?>
        <form id="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group email">
                <input type="text" name="username" placeholder="Username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <div class="error error-txt"><?php echo $username_err; ?></div>
            </div>
            <div class="form-group password">
                <input type="password" name="password" placeholder="Password" class="form-control <?php echo (!empty($t_pass_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $t_pass; ?>">
                <div class="error error-txt"><?php echo $t_pass_err; ?></div>
            </div>
            <div class="form-group submit">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            <p id="linkreg">Don't have an account? <a href="register.php">Create an account</a></p>
        </form>
    </main>
</body>
</html>
