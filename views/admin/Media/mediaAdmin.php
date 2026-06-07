<?php

$pageTitle = 'Media Upload';

$pageStyles = [
    ADMIN_CSS_PATH
];

$error = null;
$result = null;

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

        <section class="admin-panel u-mt-6">

    <div class="admin-panel__header">

        <p class="admin-kicker">
            Library
        </p>

        <h2>
            Uploaded Media
        </h2>

        <p class="admin-subtitle">
            View, edit, and delete uploaded media files.
        </p>

    </div>

    <?php 
    
    $mediaItems = $mediaService->getAllMedia();                

    if (empty($mediaItems)): ?>

        <div class="admin-empty-state">
            No media has been uploaded yet.
        </div>

    <?php else: ?>

        <div class="media-grid">

            <?php foreach ($mediaItems as $media): ?>

                <article class="media-card">

                    <div class="media-card__preview">

                        <img
                            src="<?= htmlspecialchars($media['thumb_path'] ?? $media['stored_path']) ?>"
                            alt="<?= htmlspecialchars($media['alt_text'] ?? '') ?>"
                        >

                    </div>

                    <div class="media-card__body">

                        <h3 class="media-card__title">
                            <?= htmlspecialchars($media['title'] ?: $media['original_filename']) ?>
                        </h3>

                        <p class="media-card__meta">
                            <?= htmlspecialchars($media['mime_type']) ?>
                            ·
                            <?= number_format($media['size_bytes'] / 1024, 1) ?> KB
                        </p>

                        <div class="media-card__actions">

                            <a class="button button--secondary"
                               href="/admin/media/edit?id=<?= (int) $media['id'] ?>">
                                Edit
                            </a>

                            <form method="post"
                                  action="/admin/media/delete"
                                  onsubmit="return confirm('Delete this media item?');">

                                <input type="hidden"
                                       name="id"
                                       value="<?= (int) $media['id'] ?>">

                                <button class="button button--danger"
                                        type="submit">
                                    Delete
                                </button>

                            </form>

                        </div>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</section>

        <?php include MAIN_ADMIN_FOOTER_PATH; ?>

    </div>

</body>
</html>