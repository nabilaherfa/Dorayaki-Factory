<?php
include "database.php";
$db = new MyDB();
$email = $username = $t_pass = $t_confpass = "";
$email_err = $username_err = $t_pass_err = $t_confpass_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Email is required.";
    }
    elseif (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", trim($_POST["email"]))) {
        $email_err = "Invalid email address.";
    }
    else {
        $check_email = $db->prepare("SELECT email FROM user WHERE email = :email");
        $check_email->bindValue(':email', trim($_POST["email"]), SQLITE3_TEXT);
        $result = $check_email->execute();
        $count = 0;
        while($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $count = $count + 1;
        }
        if ($count > 0) {
            $email_err = "Email is already in use.";
        }
        else {
            $email = trim($_POST["email"]);
        }
    }

    // Check username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Username is required.";
    }
    elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Only letters, numbers, and underscores are allowed.";
    }
    else {
        $check_username = $db->prepare("SELECT username FROM user WHERE username = :user");
        $check_username->bindValue(':user', trim($_POST["username"]), SQLITE3_TEXT);
        $result = $check_username->execute();
        $count = 0;
        while($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $count = $count + 1;
        }
        if ($count > 0) {
            $username_err = "Username is already taken.";
        }
        else {
            $username = trim($_POST["username"]);
        }
    }

    // Check password
    if (empty(trim($_POST["password"]))) {
        $t_pass_err = "Password is required.";
    }
    elseif (strlen(trim($_POST["password"])) < 8) {
        $t_pass_err = "Password must have at least 8 characters.";
    }
    else {
        $t_pass = trim($_POST["password"]);
    }

    // Check confirm password
    if (empty(trim($_POST["conf_password"]))) {
        $t_confpass_err = "Please confirm password.";
    }
    else {
        $t_confpass = trim($_POST["conf_password"]);
        if (empty($t_pass_err) && ($t_pass != $t_confpass)) {
            $t_confpass_err = "Password does not match.";
        }
    }

    if (empty($username_err) && empty($email_err) && empty($t_pass_err) && empty($t_confpass_err)) {
        $h_pass = password_hash($t_pass, PASSWORD_DEFAULT);
        $insert = $db->prepare("INSERT INTO user (username, pass, email, is_admin) VALUES (:uname,:pass,:email,FALSE)");
        $insert->bindParam(':uname', $username, SQLITE3_TEXT);
        $insert->bindParam(':pass', $h_pass, SQLITE3_TEXT);
        $insert->bindParam(':email', $email, SQLITE3_TEXT);
        $insert->execute();

        header("location: login.php");
    }
}
?>

<!DOCTYPE html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/register_s.css">
</head>

<body>
    <div class="wrapper">
        <h1>Create an Account</h1>
        <form id="register-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group email">
                <input type="text" name="email" placeholder="Email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <div class="error error-txt"><?php echo $email_err; ?></div>
            </div>
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <div class="error error-txt"><?php echo $username_err; ?></div>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" class="form-control <?php echo (!empty($t_pass_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $t_pass; ?>">
                <div class="error error-txt"><?php echo $t_pass_err; ?></div>
            </div>
            <div class="form-group">
                <input type="password" name="conf_password" placeholder="Confirm password" class="form-control <?php echo (!empty($t_confpass_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $t_confpass; ?>">
                <div class="error error-txt"><?php echo $t_confpass_err; ?></div>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>