<?php
    include('../sqlib.php');
    session_start();
    if (isset($_SESSION['login']) && isset($_SESSION['password']) && $_SESSION['login'] == 'root' && $_SESSION['password'] == hash("whirlpool", 'root')) {
        function check_if_exists_P()
        {
            $tab = get_categoriep();
            foreach ($tab as $key => $value) {
                foreach ($value as $field) {
                    if (!is_numeric($field)) {
                        if ($_POST['category_name_p'] == $field) {
                            return 0;
                        }
                    }
                }
            }
            return 1;
        }

        function check_if_exists_S()
        {
            $tab = get_categories();
            foreach ($tab as $key => $value) {
                foreach ($value as $field) {
                    if (!is_numeric($field)) {
                        if ($_POST['category_name_s'] == $field) {
                            return 0;
                        }
                    }
                }
            }
            return 1;
        }
        function get_id_categorie_P()
        {
            $tab = get_categoriep();
            $cate_name_p = $_GET['p_cat'];
            foreach ($tab as $key => $value) {
                foreach ($value as $field) {
                    if (is_numeric($field)) {
                        //echo "print r >>>>>> " ;print_r($_POST['category_name_P']);
                        if ($_GET['p_cat'] == $field['description_categoriep']) {
                            return $field['id_categoriep'];
                        }
                    }
                }
            }
            return -1;
        }
        // if (isset($_POST['submit']) && !empty($_POST['submit']) && isset($_POST['category_name_s']) && !empty(trim($_POST['category_name_s']))) {
        //     if ($_GET['action'] == "add_categorie") {
        //         $description_categorie = $_POST['category_name_s'];
        //         if (check_if_exists_S()) {
        //             add_categories(connect_db(), $description_categorie);
        //             $tab_s = get_categories();
        //             $endtab_s = end($tab_s);
        //             $id_s = $endtab_s['id_categories'];
        //             $id_p = get_id_categorie_P();
        //             make_categori_relation($id_s, $id_p);
        //             echo $description_categorie ." Successfully added\n";
        //         } else {
        //             echo "Error in relation\n";
        //         }
        //     }
        // }

        if (isset($_POST['submit']) && !empty($_POST['submit']) && isset($_POST['category_name_p']) && !empty(trim($_POST['category_name_p']))) {
            if ($_GET['action'] == "add_categorie") {
                $description_categorie = $_POST['category_name_p'];
                if (check_if_exists_P()) {
                    add_categoriep(connect_db(), $description_categorie);
                    echo $description_categorie ." Successfully added\n";
                } else {
                    echo "Category already exist.\n";
                }
            }
        } ?>
<html>

    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../css/style_admin.css" />
        <link href="http://fonts.googleapis.com/css?family=Terminal+Dosis" rel="stylesheet" type="text/css" />
    </head>

</html>
<div class="admin_container">
    <div class="admin_block">
        </br>
        <h1 class="active">Produits</h1></br></br>
        <ul>
            <li><a href="?action=add_product">Ajouter un produit</a></li>
            <?php if (isset($_GET['action']) && $_GET['action'] == "add_product") : ?>
            <form style="margin-top:1.2vw" action="" method="post">
                <input required placeholder="Titre" type="text" name="title" />
                <input required placeholder="Description" type="text" name="description" />
                <input required placeholder="Quantité" type="number" name="quantity" />
                <input required placeholder="Prix" type="number" name="price" />
                <input required placeholder="Categorie ID" type="number" name="catID" />
                <input type="submit" name="submit" value="ajouter" />
            </form>
            <?php
                if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['quantity']) && isset($_POST['price']) && isset($_POST['catID'])) {
                    add_produit(connect_db(), $_POST['title'], $_POST['price'], $_POST['quantity'], $_POST['description'], $_POST['catID']);
                } ?>
            <?php endif; ?>
            <li><a href="?action=modify_product">Modifier un produit</a></li>
            <?php if (isset($_GET['action']) && $_GET['action'] == "modify_product") : ?>
            <form style="margin-top:1.2vw" action="" method="post">
                <input required placeholder="ID Produit" type="text" name="pseudo" />
                <input placeholder="Titre" type="text" name="pseudo" />
                <input placeholder="Description" type="text" name="mail" />
                <input placeholder="Quantité" type="number" name="mdp" />
                <input placeholder="Image" type="text" name="perm" />
                <input type="submit" name="submit" value="modifier" />
            </form>
            <?php endif; ?>
            <li><a href="?action=delete_product">Supprimer un produit</a></li>
            <?php if (isset($_GET['action']) && $_GET['action'] == "delete_product") : ?>
            <form style="margin-top:1.2vw" action="" method="post">
                <input required placeholder="ID Produit" type="text" name="id_produit_del" />
                <input type="submit" name="delete_product" value="supprimer" />
            </form>
            <?php if (isset($_POST['id_produit_del']) && is_numeric($_POST['id_produit_del'])) {
                    del_product($_POST['id_produit_del']);
            }
            ?>
            <?php endif; ?>
        </ul>
        </br></br></br>
        <h1 class="active">Utilisateurs</h1></br></br>
        <ul>
            <li><a href="?action=add_user">Ajouter un utilisateur</a></li>
            <?php if (isset($_GET['action']) && $_GET['action'] == "add_user") : ?>
            <form style="margin-top:1.2vw" action="" method="post">
                <!-- <input required type="text" name="nom" placeholder="Name" />
                <input required type="text" name="prenom" placeholder="Lastname" /> -->
                <input required type="mail" pattern=".+@.+.com" name="new_user_mail" placeholder="Mail" />
                <input required type="text" name="new_user_login" minlength="5" placeholder="Login" />
                <input required type="password" name="new_user_passwd" minlength="8" placeholder="Password" />
                <input type="submit" name="submit" value="ajouter" />
            </form>
            <?php if (isset($_POST['new_user_mail']) && isset($_POST['new_user_login']) && isset($_POST['new_user_passwd'])) {
                    register($_POST['new_user_login'], hash("whirlpool", $_POST['new_user_passwd']), $_POST['new_user_mail']);
                } ?>
            <?php endif; ?>
            <li><a href="?action=modify_user">Modifier un utilisateur</a></li>
            <?php if (isset($_GET['action']) && $_GET['action'] == "modify_user") : ?>
            <form style="margin-top:1.2vw" action="" method="post">
            <select id="edit_user_list" name="edit_user_select">
                    <option value="edit_user" name="edit_user" selected>Modifier un Utilisateur</option>
                    <?php
                    $con = connect_db();
                    $users = get_list_users($con);
                    foreach ($users as $key => $value) {
                        foreach ($value as $id => $field) {
                            if (!is_numeric($field)) {
                                echo "<option name=\"$value[id_user]\">"."$field"."</option>";
                            }
                        }
                    } ?>
                </select>
                <input required type="text" name="login" minlength="5" placeholder="Login" />
                <input required type="text" name="nom" placeholder="Name" />
                <input required type="text" name="prenom" placeholder="Lastname" />
                <input required type="mail" pattern=".+@.+.com" name="mail" placeholder="Mail" />
                <input required type="password" name="passwd" minlength="8" placeholder="Password" />
                <input type="submit" name="submit" value="modifier" />
            </form>
            <?php endif; ?>
            <li><a href="?action=delete_user">Supprimer un utilisateur</a></li>
            <?php if (isset($_POST['edit_user_select']) && $_POST['edit_user_select'] != "") {
//                        edit_user($_POST['edit_user_select']);
                    } ?>
            <?php if (isset($_GET['action']) && $_GET['action'] == "delete_user") : ?>
            <h3>Attention !
                Cette option supprime un utilisateur sans sommation !
            </h3>
            <form style="margin-top:1.2vw" action="" method="post">
                <select id="del_user_list" name="del_user_select">
                    <option value="supprimer" name="del_user" selected>Supprimer un Utilisateur</option>
                    <?php
                    $con = connect_db();
                    $users = get_list_users($con);
                    foreach ($users as $key => $value) {
                        foreach ($value as $id => $field) {
                            if (!is_numeric($field)) {
                                echo "<option name=\"$value[id_user]\">"."$field"."</option>";
                            }
                        }
                    } ?>
                </select>
                <input type="submit" name="submit" value="supprimer" />
            </form>
                    <?php
                    if (isset($_POST['del_user_select']) && $_POST['del_user_select'] != "") {
                        del_user($_POST['del_user_select']);
                    } ?>
            <?php endif; ?>
        </ul>
        </br></br></br>
        <h1 class="active">Catégories</h1></br></br>
        <ul>
            <li><a href="?action=add_categorie">Ajouter une catégorie</a></li>
            <?php if (isset($_GET['action']) && $_GET['action'] == "add_categorie") : ?>
            <li><a>Ajouter une catégorie principale</a></li>
            <form style="margin-top:1.2vw" method="post">
                <input maxlength="50" required type="text" name="category_name_p" placeholder="Nom de la catégorie" />
                <input type="submit" name="submit" value="ajouter" />
            </form>
            <li><a>Ajouter une catégorie secondaire</a></li>
            <form style="margin-top:1.2vw;" action="" method="post">
                <select id="p_cat" name="add_s_cat">
                    <option value="ajouter" name="submit" selected>Catégorie Parent</option>
                    <?php
                    $tab = get_categoriep();
                    foreach ($tab as $key => $value) {
                        foreach ($value as $field) {
                            if (!is_numeric($field)) {
                                echo "<option value=\"$value[id_categoriep]\">"."$field"."</option>";
                            }
                        }
                        //BRVBR##%BWERTBWETBVWTRJBETWRB
                    } ?>
                </select>
                <input required type="text" id="scat_name" name="category_name_s" placeholder="Nom de la catégorie" />
                <input type="submit" name="submit" value="ajouter" />
            </form>
                <?php
                if (isset($_POST['add_s_cat']) && $_POST['add_s_cat'] != "" && isset($_POST['category_name_s'])) {
                    $con = connect_db();
                    $s_cat_id = add_categories($con, $_POST['category_name_s']);
                    // var_dump($s_cat_id);
                    // var_dump($_POST['add_s_cat']);
                    // echo $s_cat_id[0]['LAST_INSERT_ID()'];
                    make_categori_relation($s_cat_id[0]['LAST_INSERT_ID()'], $_POST['add_s_cat']);
                }
                ?>
            <?php endif; ?>
            <li><a href="?action=modify_categorie">Modifier une catégorie</a></li>
            <?php if (isset($_GET['action']) && $_GET['action'] == "modify_categorie") : ?>
            <form style="margin-top:1.2vw" action="" method="post">
                <p>Catégorie principale</p>
                <select name="edit_p_cat_id">
                    <option value="" disabled selected>Nom de la Catégorie</option>
                    <?php
                    $tab = get_categoriep();
                    foreach ($tab as $key => $value) {
                        foreach ($value as $field) {
                            if (!is_numeric($field)) {
                                echo "<option value=\"$value[id_categoriep]\">"."$field"."</option>";
                            }
                        }
                    } ?>
                </select>
                <p>Sous Catégories</p>
                <select name="edit_s_cat_id">
                    <option value="" disabled selected>Nom de la Sous-Catégorie</option>
                    <?php
                    $tab = get_categories();
                    foreach ($tab as $key => $value) {
                        foreach ($value as $field) {
                            if (!is_numeric($field)) {
                                echo "<option value=\"$value[id_categories]\">"."$field"."</option>";
                            }
                        }
                    } ?>
                </select>
                <input required type="text" name="category_name_new" placeholder="Nouveau nom" />
                <p>Ne selectionnez pas deux types de catégories différentes a la fois !</p>
                <input type="submit" name="submit" value="modifier" />
            </form>
                <?php
                // var_dump($_POST['edit_s_cat_id']);
                // var_dump($_POST['category_name_new']);
                // if (isset($_POST['edit_s_cat_id'])) {
                //     echo "TEST 1 PASS" . PHP_EOL;
                // }
                // if ($_POST['edit_s_cat_id'] != "") {
                //     echo "TEST 2 PASS" . PHP_EOL;
                // }
                // if (isset($_POST['category_name_new '])) {
                //     echo "TEST 3 PASS" . PHP_EOL;
                // }
                if (isset($_POST['edit_p_cat_id']) && $_POST['edit_p_cat_id'] != "" && isset($_POST['category_name_new'])) {
                    // echo "TEST1";
                    edit_pcat_name($_POST['edit_p_cat_id'], $_POST['category_name_new']);
                    echo "<p>Catégorie " . $_POST['edit_p_cat_id'] . " mise à jour avec succès !</p>";
                } else if (isset($_POST['edit_s_cat_id']) && $_POST['edit_s_cat_id'] != "" && isset($_POST['category_name_new'])) {
                    // echo "TEST";
                    edit_scat_name($_POST['edit_s_cat_id'], $_POST['category_name_new']);
                    echo "<p>Catégorie " . $_POST['edit_s_cat_id'] . " mise à jour avec succès !</p>";
                }
                ?>
            <?php endif ; ?>
            <!-- <li><a href="?action=delete_categorie">Supprimer une catégorie</a></li> -->
            <?php if (isset($_GET['action']) && $_GET['action'] == "delete_categorie" && 1 == 2) : ?>
            <form style="margin-top:1.2vw" action="" method="post">
            <p>Catégorie principale</p>
                <select name="delete_p_cat_id">
                    <option value="" disabled selected>Nom de la Catégorie</option>
                    <?php
                    $tab = get_categoriep();
                    foreach ($tab as $key => $value) {
                        foreach ($value as $field) {
                            if (!is_numeric($field)) {
                                echo "<option value=\"$value[id_categoriep]\">"."$field"."</option>";
                            }
                        }
                    } ?>
                </select>
                <p>Sous Catégories</p>
                <select name="delete_s_cat_id">
                    <option value="" disabled selected>Nom de la Sous-Catégorie</option>
                    <?php
                    $tab = get_categories();
                    foreach ($tab as $key => $value) {
                        foreach ($value as $field) {
                            if (!is_numeric($field)) {
                                echo "<option value=\"$value[id_categories]\">"."$field"."</option>";
                            }
                        }
                    } ?>
                </select>
                <p>Attention! La catégorie selectionnée sera supprimée sans sommation!</p>
                <input type="submit" name="submit" value="surpprimer" />
            </form>
                <?php
                if (isset($_POST['delete_p_cat_id']) && $_POST['delete_p_cat_id'] != "") {
                    // echo "TEST1";
                    del_pcat($_POST['delete_p_cat_id']);
                    echo "<p>Catégorie " . $_POST['delete_p_cat_id'] . " supprimée avec succès !</p>";
                } else if (isset($_POST['delete_s_cat_id']) && $_POST['delete_s_cat_id'] != "") {
                    // echo "TEST";
                    del_scat($_POST['delete_s_cat_id']);
                    echo "<p>Catégorie " . $_POST['delete_s_cat_id'] . " supprimée avec succès !</p>";
                }
                ?>
            <?php endif ;
} else {
    header('Location : index.php');
} ?>
        </ul>
    </div>
</div></br></br></br></br>
