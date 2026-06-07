<?php

$pageTitle = 'Admin Login';

$pageStyles = [
    ADMIN_CSS_PATH
];

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <?php include HEAD_PARTIAL_PATH; ?>

</head>

<body class="login-page">

    <section class="login-container">

        <form class="login-form" method="post">

            <?php if (!empty($message)): ?>
                <div class="login-message">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <h1 class="login-title">
                Admin Login
            </h1>

            <p class="login-subtitle">
                Sign in to manage your website.
            </p>

            <div class="form-group">
                <label for="username">
                    Username
                </label>

                <input
                    id="username"
                    type="text"
                    name="username"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">
                    Password
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                >
            </div>

            <div class="remember-row">
                <input
                    id="remember"
                    type="checkbox"
                    name="remember"
                    checked
                >

                <label for="remember">
                    Remember Me
                </label>
            </div>

            <button type="submit" class="login-button">
                Login
            </button>

            <a href="/" class="return-home-link">
                ← Return to Main Site
            </a>

        </form>

    </section>

</body>