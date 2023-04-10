<nav>
    <div id="navItemsContainer">
        <a id="navLogo" href="index.php">
            <img src="img/branding/4square_logo.svg" alt="" />
        </a>
        <div id="navLinks">
            <?php
            if (isset($_SESSION["user"])) {
                echo ('
                        <a class="button2" href="controller/loginController.php">Log out</a>        
                    ');
            } else {
                echo ('
                        <a class="button2" href="controller/loginController.php">Log in</a>
                        <a class="button1" href="signUp.php">Sign up</a>
                    ');
            }

            ?>
        </div>
    </div>
</nav>