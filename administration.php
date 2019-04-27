<?php
session_start();
include('login.php');
?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Home</title>
    <link href="./css/styles-login.css" rel="stylesheet" type="text/css" media="all" />
  </head>
<body>
<?php if (isset($_SESSION['loggued_on_user']) && !empty($_SESSION['loggued_on_user'])) : ?>
    <div class="wrapper fadeInDown">
      <div id="formContent">
      <h1 class="active">Bonjour <?php echo $_SESSION['loggued_on_user']."\n";?></h1>
      </br> </br><a href="./logout.php">Se déconnecter</a></br></br>
      </div>
    </div>
<?php else : ?> <!-- LOGIN -->
  <script type="text/javascript"> window.location = "./sign_in.php"; </script>
<?php endif; ?>
  </body>
  <script language="javascript">
    $(".message a").click(function() {
      $("form").animate({ height: "toggle", opacity: "toggle" }, "slow");
    });
  </script>
</html>
