<?php

$currentUsername = $_SESSION['username'] ?? 'Unknown';

?>

<header class="admin-header">

    <div class="admin-header-container">

        <a class="admin-brand" href="/admin/dashboard">
            <?= htmlspecialchars($currentUsername) ?>
        </a>

        <?php include MAIN_ADMIN_NAVIGATION_PATH; ?>

        <a class="admin-logout" href="/logout">
            Logout
        </a>

    </div>

</header>