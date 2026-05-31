<?php

$pageTitle = 'Home';

$pageStyles = [
];

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <?php include HEAD_PARTIAL_PATH; ?>

</head>

<body>

<?php include MAIN_HEADER_PATH; ?>

<main class="home-page">

    <section class="hero-section">

        <div class="hero-content">

            <h1 class="hero-title">
                Elias Broniecki
            </h1>

            <p class="hero-subtitle">
                Developer • Writer • IT Professional
            </p>

            <p class="hero-description">
                Building software, writing horror, and creating things that matter.
            </p>

            <div class="hero-actions">

                <a class="primary-button"
                   href="/blog">

                    Read the Blog

                </a>

                <a class="secondary-button"
                   href="/admin/media">

                    Media Admin

                </a>

            </div>

        </div>

    </section>

</main>

<?php include MAIN_FOOTER_PATH; ?>

</body>

</html>