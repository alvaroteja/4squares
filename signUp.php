<?php
session_start();
//si entramos aqui y se está logueado, nos manda a logout
if (isset($_SESSION['user'])) {
    header("Location: logout.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>4squares</title>
    <link rel="stylesheet" href="style/login.css" />
</head>

<body>
    <?php
    include("html/components/nav.php");

    ?>
    <div class="container">
        <img id="logo1" src="img/branding/square_blue.svg" alt="" />
        <form action="controller/signUpController.php" method="post">
            <h3>Sing up</h3>
            <div class="inputContainer">
                <label for="username">Nombre*</label>
                <input type="text" placeholder="Frodo" id="username" />
            </div>
            <div class="inputContainer">
                <label for="username">Apellido*</label>
                <input type="text" placeholder="Bolsón" id="username" />
            </div>
            <div class="inputContainer">
                <label for="username">Email*</label>
                <input type="text" placeholder="fbolson@tierramedia.tk" id="username" />
            </div>
            <div class="inputContainer">
                <label for="username">Nombre de usuario*</label>
                <input type="text" placeholder="SrHobbit25" id="username" />
            </div>
            <div class="inputContainer">
                <label for="password">Contraseña*</label>
                <input type="password" placeholder="unanilloparagobernarlosatodos" id="password" />
            </div>

            <button>Enviar</button>
            <a id="loginRelink" href="controller/loginController.php">Log in</a>
        </form>
        <img id="logo2" src="img/branding/square_blue.svg" alt="" />
        <input type="hidden" name="signUp" value="true">
    </div>
</body>

</html>