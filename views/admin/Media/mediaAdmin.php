<?php

$pageTitle = 'Media Upload';

$pageStyles = [
    ADMIN_CSS_PATH
];

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
                        Media
                    </p>

                    <h1 class="admin-title">
                        Media Upload
                    </h1>

                    <p class="admin-subtitle">
                        Upload a file to your test upload folder and insert a row into the media table.
                    </p>

                </section>

                <section class="admin-panel u-mt-6">

                    <form class="form" method="post" enctype="multipart/form-data">

                        <div class="form__field">

                            <label class="form__label" for="media-file">
                                Choose file
                            </label>

                            <input
                                class="form__control"
                                id="media-file"
                                type="file"
                                name="file"
                                required
                            >

                            <p class="form__hint">
                                This saves the file to a test upload folder and inserts a row into <code>media</code>.
                            </p>

                        </div>

                        <div class="form__actions">

                            <button class="button" type="submit">
                                Upload
                            </button>

                            <a class="button button--secondary" href="/admin/media">
                                Back to Media
                            </a>

                        </div>

                    </form>

                </section>

                <?php if ($error): ?>

                    <section class="admin-panel u-mt-6">

                        <div class="alert alert--error">
                            <strong>Error</strong>
                        </div>

                        <pre class="code-block u-mt-4"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></pre>

                    </section>

                <?php endif; ?>

                <?php if ($result): ?>

                    <section class="admin-panel u-mt-6">

                        <div class="alert alert--success">
                            <strong>Inserted Media</strong>
                        </div>

                        <pre class="code-block u-mt-4"><?= htmlspecialchars(print_r($result, true), ENT_QUOTES, 'UTF-8') ?></pre>

                    </section>

                <?php endif; ?>

            </div>

        </main>

        <?php include MAIN_ADMIN_FOOTER_PATH; ?>

    </div>

</body>
</html>