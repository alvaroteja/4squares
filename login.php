<?php
include("generalData/messages.php");
session_start();

//si entramos aqui y se está logueado, nos manda a logout
if (isset($_SESSION['user'])) {
    header("Location: logout.php");
}


$userName = "";
$userNameMessage = "";
$password = "";
$passwordMessage = "";
$errorMessage = "";

if (isset($_GET['userName'])) {
    if ($_GET['userName']  == "empty") {
        $userNameMessage = "<p class='errorMessage'>" . $generalUserNameMessage . "</p>";
    } else {
        $userName = $_GET['userName'];
    }
}

if (isset($_GET['password'])) {
    if ($_GET['password']  == "empty") {
        $passwordMessage = "<p class='errorMessage'>$generalPasswordMessage</p>";
    }
}

if (isset($_GET['userOrPass'])) {
    if ($_GET['userOrPass']  == "noMatches") {
        $errorMessage = "<p class='errorMessage'>$generalErrorMessage</p>";
    }
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
        <form action="controller/loginController.php" method="post">
            <h3>Login</h3>
            <div class="inputContainer">
                <label for="userName">Username</label>
                <input name="userName" type="text" placeholder="lhojaverde@bosquenegro.elf" id="userName" value="<?php echo $userName ?>" />
                <?php echo ($userNameMessage); ?>

            </div>
            <div class="inputContainer">
                <label for="password">Password</label>
                <input name="password" type="password" placeholder="pandelembas" id="password" />
                <?php echo ($passwordMessage); ?>
            </div>
            <button>Log in</button>
            <a id="loginSingupLink" href="signUp.php">Sign up</a>
            <?php echo ($errorMessage); ?>
            <input type="hidden" name="login" value="true">
        </form>
        <img id="logo2" src="img/branding/square_blue.svg" alt="" />
    </div>
</body>

</html>