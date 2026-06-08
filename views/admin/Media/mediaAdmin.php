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

    if (empty($mediaItems)): ?>

        <div class="admin-empty-state">
            No media has been uploaded yet.
        </div>

    <?php else: ?>

        <div class="media-grid">

            <?php foreach ($mediaItems as $media): ?>

                <article class="media-card">

                    <div class="media-card__preview">

                    <button
                        class="media-preview-button"
                        type="button"
                        data-full-src="<?= htmlspecialchars($media->getStoredPath(), ENT_QUOTES, 'UTF-8') ?>"
                        data-alt="<?= htmlspecialchars($media->getAltText() ?? $media->getOriginalFilename(), ENT_QUOTES, 'UTF-8') ?>"
                    >
                        <img
                            src="<?= htmlspecialchars($media->getThumbPath() ?? $media->getStoredPath(), ENT_QUOTES, 'UTF-8') ?>"
                            alt="<?= htmlspecialchars($media->getAltText() ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        >
                    </button>

                </div>

                    <div class="media-card__body">

                        <h3 class="media-card__title">
                            <?= htmlspecialchars($media->getTitle() ?? $media->getOriginalFilename()) ?>
                        </h3>

                        <p class="media-card__meta">
                            <?= htmlspecialchars($media->getMimeType()) ?>
                            ·
                            <?= number_format($media->getSizeBytes() / 1024, 1) ?> KB
                        </p>

                        <div class="media-card__actions">

                            <a class="button button--secondary"
                               href="/admin/media/edit?id=<?= (int) $media->getId() ?>">
                                Edit
                            </a>

                            <form method="post"
                                  action="/admin/media/delete"
                                  onsubmit="return confirm('Delete this media item?');">

                                <input type="hidden"
                                       name="id"
                                       value="<?= (int) $media->getId() ?>">

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
<div class="media-lightbox" id="media-lightbox" aria-hidden="true">
    <button class="media-lightbox__close" type="button" aria-label="Close image preview">
        &times;
    </button>

    <img class="media-lightbox__image" src="" alt="">
</div>

<script>
    const lightbox = document.getElementById('media-lightbox');
    const lightboxImage = lightbox.querySelector('.media-lightbox__image');
    const closeButton = lightbox.querySelector('.media-lightbox__close');

    document.querySelectorAll('.media-preview-button').forEach((button) => {
        button.addEventListener('click', () => {
            lightboxImage.src = button.dataset.fullSrc;
            lightboxImage.alt = button.dataset.alt || '';

            lightbox.classList.add('is-open');
            lightbox.setAttribute('aria-hidden', 'false');
        });
    });

    function closeLightbox() {
        lightbox.classList.remove('is-open');
        lightbox.setAttribute('aria-hidden', 'true');
        lightboxImage.src = '';
        lightboxImage.alt = '';
    }

    closeButton.addEventListener('click', closeLightbox);

    lightbox.addEventListener('click', (event) => {
        if (event.target === lightbox) {
            closeLightbox();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && lightbox.classList.contains('is-open')) {
            closeLightbox();
        }
    });
</script>
</body>
</html>