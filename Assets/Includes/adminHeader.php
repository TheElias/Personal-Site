<header id="header">    
    <section class="main-header">
        <div class="headerLogoText">
            <a href="../">

            Hello
                <?php 

                $user = new User();
                $user->loadUserByUsername($_SESSION['username']);
                echo $user->getFullName();

                ?>
             </a>
        </div>

        

        <div class = "logout">
            <ul>
                <li><a href="../Assets/Includes/logout.php">Logout</a></li>
            </ul>
        </div>
    </section>

    <?php   

include("Assets/Includes/adminNavigation.php");
?>
    
</header>       
<!--Navigation-->
