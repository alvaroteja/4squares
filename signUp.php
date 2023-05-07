<?php
include("service/AvatarService.php");
include("./model/UserModel.php");
include("./service/DBConnection.php");
session_start();
//si entramos aqui y se está logueado, nos manda a logout
if (isset($_SESSION['user'])) {
    header("Location: logout.php");
}

//repintado de datos
$name = "";
$surname = "";
$email = "";
$userName = "";
$password = "";

if (isset($_SESSION['signUpData'])) {
    $dataList = $_SESSION['signUpData'];

    $name = $dataList["name"];
    $surname = $dataList["surname"];
    $email = $dataList["email"];
    $userName = $dataList["userName"];
}
//pintado de errores
$nameError = "";
$surnameError = "";
$emailError = "";
$userNameError = "";
$passwordError = "";
$password2Error = "";

if (isset($_SESSION['signUpErrors'])) {
    $errorList = $_SESSION['signUpErrors'];
    if (isset($errorList["name"]) && count($errorList["name"]) > 0) {
        foreach ($errorList["name"] as $error) {
            $nameError = $nameError . $error . "<br><br>";
        }
    }
    if (isset($errorList["surname"]) && count($errorList["surname"]) > 0) {
        foreach ($errorList["surname"] as $error) {
            $surnameError = $surnameError . $error . "<br><br>";
        }
    }
    if (isset($errorList["email"]) && count($errorList["email"]) > 0) {
        foreach ($errorList["email"] as $error) {
            $emailError = $emailError . $error . "<br><br>";
        }
    }
    if (isset($errorList["userName"]) && count($errorList["userName"]) > 0) {
        foreach ($errorList["userName"] as $error) {
            $userNameError = $userNameError . $error . "<br><br>";
        }
    }
    if (isset($errorList["password"]) && count($errorList["password"]) > 0) {
        foreach ($errorList["password"] as $error) {
            $passwordError = $passwordError . $error . "<br><br>";
        }
    }
    if (isset($errorList["password2"]) && count($errorList["password2"]) > 0) {
        foreach ($errorList["password2"] as $error) {
            $password2Error = $password2Error . $error . "<br><br>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>4squares</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous" />
    <link rel="stylesheet" href="style/login.css" />
</head>

<body>
    <?php
    include("html/components/nav.php");

    ?>
    <div class="container">
        <img id="logo1" src="img/branding/square_blue.svg" alt="" />
        <form action="controller/signUpController.php" method="post">
            <h3>Sign up</h3>
            <div class="inputContainer">
                <label for="name">Nombre*</label>
                <input type="text" placeholder="Frodo" id="name" name="name" value="<?php echo $name ?>" />
                <?php echo ("<p class='errorMessage'>$nameError</p>"); ?>
            </div>
            <div class="inputContainer">
                <label for="surname">Apellido*</label>
                <input type="text" placeholder="Bolsón" id="surname" name="surname" value="<?php echo $surname ?>" />
                <?php echo ("<p class='errorMessage'>$surnameError</p>"); ?>
            </div>
            <div class="inputContainer">
                <label for="email">Email*</label>
                <input type="text" placeholder="fbolson@tierramedia.tk" id="email" name="email" value="<?php echo $email ?>" />
                <?php echo ("<p class='errorMessage'>$emailError</p>"); ?>
            </div>
            <div class="inputContainer">
                <label for="userName">Nombre de usuario*</label>
                <input type="text" placeholder="SrHobbit25" id="userName" name="userName" value="<?php echo $userName ?>" />
                <?php echo ("<p class='errorMessage'>$userNameError</p>"); ?>
            </div>
            <div class="inputContainer">
                <label for="password">Contraseña*</label>
                <input type="password" placeholder="unanilloparagobernarlosatodos" id="password" name="password" />
                <?php echo ("<p class='errorMessage'>$passwordError</p>"); ?>
            </div>
            <div class=" inputContainer">
                <label for="password2">Repite la contraseña*</label>
                <input type="password" placeholder="unanilloparagobernarlosatodos" id="password2" name="password2" />
                <?php echo ("<p class='errorMessage'>$password2Error</p>"); ?>
            </div>

            <button>Enviar</button>
            <a id="loginRelink" href="controller/loginController.php">Log in</a>
            <input type="hidden" name="signUp" value="true">
        </form>
        <img id="logo2" src="img/branding/square_blue.svg" alt="" />
    </div>

    <?php
    unset($_SESSION["signUpErrors"]);
    unset($_SESSION["signUpData"]);
    ?>
</body>

</html>