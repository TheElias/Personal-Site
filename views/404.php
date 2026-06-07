<?php

http_response_code(404);

$pageTitle = '404: Page Not Found';

$pageStyles = [
];

$requestedPath = $_SERVER['REQUEST_URI'] ?? '/';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include HEAD_PARTIAL_PATH; ?>
</head>

<body class="site-page">

    <div class="site-shell">

        <?php include MAIN_HEADER_PATH; ?>

        <main class="not-found-page">

            <section class="not-found-card">

                <p class="not-found-kicker">
                    404
                </p>

                <h1 class="not-found-title">
                    Page Not Found
                </h1>

                <p class="not-found-message">
                    Sorry, the page you are looking for does not exist or may have been moved. Or I didn't make it. Or the URL is wrong. Or it has a bug. Or something went wrong. But either way, I can't find it.
                </p>

                <p class="not-found-path">
                    Requested page:
                    <code><?= htmlspecialchars($requestedPath, ENT_QUOTES, 'UTF-8') ?></code>
                </p>

                <div class="not-found-actions">

                    <a class="primary-button" href="/">
                        Return Home
                    </a>

                    <a class="secondary-button" href="/blog">
                        Visit Blog
                    </a>

                </div>

            </section>

        </main>

        <?php include MAIN_FOOTER_PATH; ?>

    </div>

</body>
</html>