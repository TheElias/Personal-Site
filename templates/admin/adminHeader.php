<?php 
                
    $currentUsername = $_SESSION['username'] ?? 'Unknown';
  ?>



<header id="header">    
    <section class="main-header">
        <div class="headerLogoText">
            <a href="../">
          <?php
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

include MAIN_ADMIN_NAVIGATION_PATH;
?>
    
</header>       
<!--Navigation-->
