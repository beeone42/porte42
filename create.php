<?php

include('sqlib.php');

session_start();
if ($_POST["submit"] == "register" and !empty($_POST["login"]) and !empty($_POST["passwd"]) and !empty($_POST["mail"])) {
    if (is_pseudo_exist(connect_db(), $_POST['login'])) {
        header('Location: sign_in.php?register=true&check=pexists');
    } elseif (is_mail_exist(connect_db(), $_POST['mail'])) {
        header('Location: sign_in.php?register=true&check=mexists');
    } else {
        $account = array("login" => $_POST["login"], "passwd" => hash("whirlpool", $_POST["passwd"]));
        $login = $_POST["login"];
        $_SESSION["new_user"] = $login;


        $pseudo_user = $_POST["login"];
        $passwd_user = hash("whirlpool", $_POST["passwd"]);
        $email_user = $_POST["mail"];

        register($pseudo_user, $passwd_user, $email_user);
        header('Location: sign_in.php');/// il faut lui dire que c'est ok
    }
} else {
    header('Location: sign_in.php?register=true');
} //// error
