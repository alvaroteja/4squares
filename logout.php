<?php
include("service/AvatarService.php");
include("./model/UserModel.php");
include("./service/DBConnection.php");
session_start();
//Si se entra aqui sin estar logueado, nos manda a login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>4squares - log out</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous" />
    <link rel="stylesheet" href="style/login.css" />
    <link rel="icon" href="./img/icons/favicon.ico">
</head>

<body>
    <?php
    include("html/components/nav.php");
    ?>
    <div class="container">
        <img id="logo1" src="img/branding/square_blue.svg" alt="" />
        <form action="controller/loginController.php" method="post">
            <h3>¿Cerrar sesión?</h3>
            <button>Cerrar</button>
            <input type="hidden" name="logout" value="true">
        </form>
        <img id="logo2" src="img/branding/square_blue.svg" alt="" />

    </div>
</body>

</html>