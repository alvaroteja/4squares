<nav>
    <div id="navItemsContainer">
        <a id="navLogo" href="index.php">
            <img src="img/branding/4square_logo.svg" alt="" />
        </a>
        <div id="navLinks">
            <?php
            if (isset($_SESSION["user"])) {
                // $connnection = new DBConnection();
                // $avatarService = new AvatarService($connnection);
                // $avatarUrl = $avatarService->getAvatarByID($_SESSION["user"]->getId_avatar());
                $avatarUrl =  $_SESSION["user"]->getId_avatar();
                $userName = $_SESSION["user"]->getNickname();
                echo ("
                        <a class='button2' href='controller/loginController.php'>Log out</a>  
                        <a id='userPanelLink' href='./userPanel.php'>
                            <div id='navUser'>
                                <img id='navUserImg' src='./img/avatars/$avatarUrl' alt=''>
                                <p id='navUserName'>$userName</p>
                            </div>      
                        </a>  
                    ");
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