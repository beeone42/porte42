<?php
session_start();
    include 'login.php';
?>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <title>Home</title>
        <link href="./css/styles-login.css" rel="stylesheet" type="text/css" media="all" />
    </head>

    <body>
        <?php if (isset($_SESSION['loggued_on_user']) && !empty($_SESSION['loggued_on_user'])): ?>
        <script type="text/javascript">
        window.location = "./index.php";
        </script>
        <?php
        elseif ((isset($_GET['register']) && ($_GET['register'] == "true")) || (isset($_POST['submit']) && $_POST['submit'] == "register")):
        ?>
        <!-- REGISTER -->
        <div class="wrapper fadeInDown">
            <div id="formContent">
                <!-- Tabs Titles -->
                <a href="./sign_in.php">
                    <h2 class="inactive underlineHover"> Login </h2>
                </a>
                <a href="./sign_in.php?register=true">
                    <h2 class="active"> Register </h2>
                </a>
                <form action="./create.php" method="POST">
                    <!-- Register Form -->
                    <input required type="mail" pattern=".+@.+.com" id="mail" class="fadeIn second" name="mail"
                        placeholder="Mail" />
                    <input required type="text" id="login" class="fadeIn second" name="login" minlength="5"
                        placeholder="Login" />
                    <input required type="password" id="password" class="fadeIn third" name="passwd" minlength="8"
                        placeholder="Password" />
                    <?php if (isset($_GET['check']) && $_GET['check'] == "pexists") {
            echo "<p>Ce login existe déjà.</p>";
        } elseif ($_GET['check'] && $_GET['check'] == "mexists") {
            echo "<p>Ce email existe déjà.</p>";
        } ?>
                    <input style="margin-top:35px;margin-bottom:30px;" required type="submit" name="submit"
                        class="fadeIn fourth" value="register" />
                    <?php if (isset($_GET['login']) && $_GET['login'] == "used") {
            echo '<p>Login already used</p>';
        }
?>
                </form>
            </div>
        </div>
        <?php else: ?>
        <!-- LOGIN -->
        <div class="wrapper fadeInDown">
            <?php if (isset($_GET['success']) && $_GET['success'] == "true"): ?>
            <h1 id="success">Bonjour <?php echo $_SESSION["new_user"] . "\n" ?>
                ! Votre nouveau compte a été créé avec
                succès !
            </h1>
            <?php endif;?>
            <div id="formContent">
                <h2 class="active"> Login </h2>
                <a href="./sign_in.php?register=true">
                    <h2 class="inactive underlineHover">Register </h2>
                </a>
                <form style="margin-top:30px" method="POST"> <input type="text" id="login" class="fadeIn second"
                        name="login" placeholder="Username" />
                    <input type="password" id="password" class="fadeIn third" name="passwd" placeholder="Password" />
                    <input style="margin-top:35px;margin-bottom:30px;" type="submit" name="submit" class="fadeIn fourth"
                        value="OK" /><?php
if (isset($_POST['submit']) && $_POST['submit'] == "OK" && start_login() == -2) {
    echo "<p>Nom d'utilisateur et/ou mot de passe erroné.</p>";
}
?>
                </form>
            </div>
        </div>
        <?php endif;?>
    </body>
    <script language="javascript">
    $(".message a").click(function() {
        $("form").animate({
            height: "toggle",
            opacity: "toggle"
        }, "slow");
    });
    </script>

</html>
