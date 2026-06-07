<?php

$pageTitle = 'Admin Dashboard';

$pageStyles = [
    ADMIN_CSS_PATH
];

$currentUsername = $_SESSION['username'] ?? 'Unknown';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include HEAD_PARTIAL_PATH; ?>
</head>

<body class="admin-page">

    <div class="admin-shell">

        <?php include MAIN_ADMIN_HEADER_PATH; ?>

        <main class="admin-main">

            <div class="admin-container">

                <section class="admin-dashboard-hero">

                    <p class="admin-kicker">
                        Admin
                    </p>

                    <h1 class="admin-title">
                        Dashboard
                    </h1>

                    <p class="admin-subtitle">
                        Welcome back, <?= htmlspecialchars($currentUsername) ?>.
                    </p>

                </section>

                <section class="admin-card-grid">

                    <a class="admin-card" href="/admin/media">
                        <h2>Media</h2>
                        <p>Upload and manage site images and files.</p>
                    </a>

                    <a class="admin-card" href="/admin/blog">
                        <h2>Blog Posts</h2>
                        <p>Create, edit, and publish blog content.</p>
                    </a>

                    <a class="admin-card" href="/admin/users">
                        <h2>Users</h2>
                        <p>Manage users and permissions.</p>
                    </a>

                </section>

            </div>

        </main>

        <?php include MAIN_ADMIN_FOOTER_PATH; ?>

    </div>

</body>
</html>