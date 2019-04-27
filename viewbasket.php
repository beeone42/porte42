<?php
    session_start();
    require 'sqlib.php';
    if ($_GET['additem'] != null) {
        $_SESSION['items'][] = $_GET['additem'];
    }
    $con = connect_db();
if (isset($_GET['cat'])) {
    if ($_SESSION["cat"] && $_GET['sort'] == "asc") {
        $products = get_produit_categoriep($_SESSION["cat"]);
    } elseif ($_SESSION["cat"] && $_GET['sort'] == "desc") {
        $products = get_produit_categoriep_desc($_SESSION["cat"]);
    } else {
        $products = get_produit_categoriep($_GET['cat']);
    }
    $_SESSION["cat"] = $_GET['cat'];
} elseif (isset($_GET['subcat'])) {
    if ($_SESSION["subcat"] && $_GET['sort'] == "asc") {
        $products = get_produit_categories($_SESSION["subcat"]);
    } elseif ($_SESSION["subcat"] && $_GET['sort'] == "desc") {
        $products = get_produit_categories_desc($_SESSION["subcat"]);
    } else {
        $products = get_produit_categories($_GET['subcat']);
    }
    $_SESSION["subcat"] = $_GET['subcat'];
} else {
    $products = get_list_produit($con);
}
$main_cat = get_categoriep();
$sub_cat = get_categories();
?>

<head>
    <meta charset="utf-8" />
    <title>Basket</title>
    <link rel="stylesheet" href="css/style.css" />
    <link href="http://fonts.googleapis.com/css?family=Terminal+Dosis" rel="stylesheet" type="text/css" />
</head>

<body>
    <header>
        <div class="wrapper">
            <h1><a href="index.php" id="brand" title="Rush00">Rush00</a></h1>
            <nav>
                <?php foreach ($main_cat as $key => $value) {
    ?>
                <ul>
                    <li>
                        <a
                            href="search.php?cat=<?php echo $main_cat[$key]['id_categoriep']; ?>">
                            <?php echo $main_cat[$key]['description_categoriep']; ?></a>
                        <?php $sscat = get_categories_related_to_P($main_cat[$key]['id_categoriep']); ?>
                        <ul class="sub-menu"><?php
                            foreach ($sscat as $key => $value) {
                                ?>
                            <li><a
                                    href="search.php?subcat=<?php echo $sscat[$key]['id_categories']; ?>">
                                    <?php echo $sscat[$key]['description_categories']; ?></a>
                            </li>
                            <?php
                            } ?>
                        </ul>

                    </li>
                </ul>
                <?php
} ?>
            </nav>
        </div>
    </header>
    <aside id="top">
        <div class="wrapper">
            <ul id="social">
                <li>
                    <a href="https://www.facebook.com/42born2code/" class="facebook" title="like us us on Facebook">like
                        us us on Facebook</a>
                </li>
                <li>
                    <a href="https://twitter.com/42born2code" class="twitter" title="follow us on twitter">follow us on
                        twitter</a>
                </li>
            </ul>
            <form>
                <input type="text" placeholder="Search Rush00..." /><button type="submit">
                    Search
                </button>
            </form>
            <div id="action-bar">
                <?php if (isset($_SESSION['loggued_on_user']) && !empty($_SESSION['loggued_on_user'])) : ?>
                <a href="administration.php">My Account</a> /
                <a href="logout.php">Logout</a> /
                <?php else : ?>
                <a href="sign_in.php">Login/Register</a> /
                <?php endif;?>
                <a href="viewbasket.php">Your bag (0)</a>
            </div>
        </div>
    </aside>
    <article id="basket">
        <h1>Shopping Bag</h1>
        <table width="100" border="1">
            <tr>
                <th scope="col" class="description">Product</th>
                <th scope="col" class="options">Options</th>
                <th align="right" scope="col" class="price">Price</th>
            </tr>
            <?php
            $i = 0;
            $cmp = 0;
            if (isset($_GET['remove'])) {
                foreach ($_SESSION['items'] as $k => $value) {
                    if ($cmp == $_GET['remove'])
                    {
                        unset($_SESSION['items'][$k]);
                        break ;
                    }
                    $cmp++;
                }
                 $_SESSION['items'] = array_values($_SESSION['items']);
            }
            if ($_GET['additem'] || isset($_SESSION['items'])) {
                while ($_SESSION['items'][$i]) {
                    ?>
            <tr>
                <td align="left" valign="top" class="description">
                    <a
                        href="product.php?id=<?php echo $_SESSION['items'][$i]; ?>"><img
                            src="images/thumb1.jpg" class="left" />
                        <p>
                            <a
                                href="product.php?id=<?php echo $_SESSION['items'][$i]; ?>"><?php
                        $produit = get_produit($con, $_SESSION['items'][$i]);
                    echo $produit[0]['nom_produit']; ?></a><br /><?php echo $produit[0]['description_produit']; ?>
                        </p>
                </td>
                <td aligh="left" valign="top" class="options">
                    <dl>
                        <dt>Product ID</dt>
                        <dd><?php echo $produit[0]['id_produit']; ?>
                        <dt><a href="viewbasket.php?remove=<?php echo $i ?>">Remove Product</a></dt>
                        </dd>
                    </dl>
                </td>
                <td align="right" valign="top" class="price">&euro;<?php echo $produit[0]['prix_produit']; ?>
                <?php $cart_price += $produit[0]['prix_produit']; ?>
                </td>
            </tr>

            <?php $i++ ;
                }
            } ?>
            <!--           <tr>
                <td align="left" valign="top" class="description">
                    <a href="main.php"><img src="images/thumb1.jpg" alt="Elegant evening Dress" class="left" /></a>
                    <p>
                        <a href="main.php">Elegant evening Dress</a><br />Lorem ipsum
                        dolor sit amet, consectetur adipiscing elit. Nulla volutpat
                        ultricies fringilla. Suspendisse iaculis tristique leo, id
                        adipiscing massa aliquet ut. Etiam adipiscing auctor enim nec
                        tincidunt.
                    </p>
                    <a href="#">Remove</a>
                </td>
                <td align="left" valign="top" class="options">
                    <dl>
                        <dt>Product ID</dt>
                        <dd>6442567</dd>
                        <dt>Size:</dt>
                        <dd>S</dd>
                        <dt>Quantity:</dt>
                        <dd>1</dd>
                    </dl>
                    <button>Change details</button>
                </td>
                <td align="right" valign="top" class="price">&euro;249</td>
            </tr>
            <tr>
                <td align="left" valign="top" class="description">
                    <a href="main.php"><img src="images/thumb1.jpg" alt="Elegant evening Dress" class="left" /></a>
                    <p>
                        <a href="main.php">Elegant evening Dress</a><br />Lorem ipsum
                        dolor sit amet, consectetur adipiscing elit. Nulla volutpat
                        ultricies fringilla. Suspendisse iaculis tristique leo, id
                        adipiscing massa aliquet ut. Etiam adipiscing auctor enim nec
                        tincidunt.
                    </p>
                    <a href="#">Remove</a>
                </td>
                <td align="left" valign="top" class="options">
                    <dl>
                        <dt>Product ID</dt>
                        <dd>1936246</dd>
                        <dt>Size:</dt>
                        <dd>S</dd>
                        <dt>Quantity:</dt>
                        <dd>1</dd>
                    </dl>
                    <button>Change details</button>
                </td>
                <td align="right" valign="top" class="price">&euro;249</td>
            </tr>
            <tr>
                <td align="left" valign="top" class="description">
                    <a href="main.php"><img src="images/thumb1.jpg" alt="Elegant evening Dress" class="left" /></a>
                    <p>
                        <a href="main.php">Elegant evening Dress</a><br />Lorem ipsum
                        dolor sit amet, consectetur adipiscing elit. Nulla volutpat
                        ultricies fringilla. Suspendisse iaculis tristique leo, id
                        adipiscing massa aliquet ut. Etiam adipiscing auctor enim nec
                        tincidunt.
                    </p>
                    <a href="#">Remove</a>
                </td>
                <td align="left" valign="top" class="options">
                    <dl>
                        <dt>Product ID</dt>
                        <dd>1936246</dd>
                        <dt>Size:</dt>
                        <dd>S</dd>
                        <dt>Quantity:</dt>
                        <dd>1</dd>
                    </dl>
                    <button>Change details</button>
                </td>
                <td align="right" valign="top" class="price">&euro;249</td>
            </tr> -->
        </table>

        <img src="images/creditcards.gif" class="safe" style="padding-right: 10px; margin-top: 20px;"" />
        <div class=" right">
        <strong>Subtotal before Delivery Charges</strong> <em>&euro;<?php echo $cart_price ?></em><br />
        <p>
            <select>
                <option>Free delivery (3-5 days)</option>
                <option>Next day delivery (&euro;3.99)</option>
            </select>
            <em>&euro;0.00</em>
        </p>
        <strong style="padding-bottom: 10px;">Your total</strong> <em>&euro;<?php echo $cart_price ?></em>
        </div>
        <button class="continue" href="order.php" style="margin-top: 10px;">Pay securely now</button>
    </article>
    <footer>
        <div class="wrapper">
            <span class="logo">Rush00</span>
            <a href="#" target="_blank" title="title" class="right">Web Design 42</a>
            &copy; Rush00 <a href="#">Sitemap</a>
            <a href="#">Terms &amp; Conditions</a>
            <a href="#">Shipping &amp; Returns</a> <a href="#">Size Guide</a><a href="#">Help</a> <br />
        </div>
    </footer>
</body>

</html>
