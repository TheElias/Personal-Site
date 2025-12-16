<?php 
                
    $currentUsername = $_SESSION['username'] ?? 'Unknown';
  ?>



<header id="header">    
    <section class="main-header">
        <div class="headerLogoText">
            <a href="../">
fart          <?php
              echo $currentUsername;

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
