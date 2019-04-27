<html>

<head>
    <meta charset="utf-8" />
    <title>Rush00</title>
    <link rel="stylesheet" href="../css/styles-login.css" />
    <link href="http://fonts.googleapis.com/css?family=Terminal+Dosis" rel="stylesheet" type="text/css" />
</head>

</html>
<?php
session_start();
function auth_admin()
{
    $user = 'root';
    $password_def = 'root';

    if (isset($_POST['submit']) && $_POST['submit'] == "submit") {
        $username = $_POST['login'];
        $password = $_POST['password'];
        if ($username && $password) {
            if ($username == $user && $password == $password_def) {
                $_SESSION['login'] = $username;
                $_SESSION['password'] = hash("whirlpool", $password);
                return 1;
            } else {
                return 2;
            }

        }
    }
}
?>
<div class="wrapper fadeInDown">
    <div id="formContent">
        <h1 class="active">Administration</h1>
        <form action="" method="POST">
            <input style="margin-top:30px" type="text" id="login" class="fadeIn second" name="login"
                placeholder="Username" />
            <input required type="password" id="password" class="fadeIn third" name="password" placeholder="Password" />
            <input style="margin-top:35px;margin-bottom:30px;" type="submit" name="submit" class="fadeIn fourth"
                value="submit" />
            <?php if (auth_admin() == 1): ?>
            <script type="text/javascript">
            window.location = "admin.php";
            </script>
            <?php elseif (auth_admin() == 2): ?>
            <p>Invalid login or password</p>
            <?php endif;?>

        </form>
    </div>
</div>
