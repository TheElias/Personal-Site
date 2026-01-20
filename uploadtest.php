<?php
declare(strict_types=1);

require __DIR__ . '/Assets/Includes/init.php';

use Site\Database;
use Site\MediaDAO;
use Site\MediaStorage;
use Site\MediaService;

$error = null;
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 1) DB
        $db = Database::fromEnvironment();
        $db->connect();

        $mediaDao = new MediaDAO($db->getConnection());

        // 2) Storage root (where files get saved)
        // This should be a real directory that your web server can write to.
        // Example: /var/www/site/public/uploads  (linux)
        // For your local Windows dev, point it somewhere writable.
        $uploadRoot = __DIR__ . '/../uploads'; // e.g. public/admin/uploads (test-only)
        if (!is_dir($uploadRoot)) {
            mkdir($uploadRoot, 0755, true);
        }

        $storage = new MediaStorage($uploadRoot);

        // 3) Uploader (workflow)
        $uploader = new MediaService($mediaDao, $storage);

        // 4) Upload
        if (!isset($_FILES['file'])) {
            throw new RuntimeException('No file uploaded.');
        }

        $media = $uploader->upload($_FILES['file']); // returns Media with ID assigned

        $result = [
            'id'            => $media->getId(),
            'type'          => $media->getType(),
            'mime_type'     => $media->getMimeType(),
            'original_name' => $media->getOriginalName(),
            'stored_name'   => $media->getStoredName(), // this is your storage key
            'size_bytes'    => $media->getSizeBytes(),
            'width'         => $media->getWidth(),
            'height'        => $media->getHeight(),
            'created_at'    => $media->getCreatedAt()->format('Y-m-d H:i:s'),
            'saved_path'    => $storage->pathFor($media->getStoredName()),
        ];

    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Media Upload Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: system-ui, sans-serif; margin: 24px; max-width: 900px; }
        .box { padding: 16px; border: 1px solid #ccc; border-radius: 8px; margin-bottom: 16px; }
        pre { background: #f6f6f6; padding: 12px; border-radius: 8px; overflow:auto; }
        .error { border-color: #c00; }
        .ok { border-color: #0a0; }
    </style>
</head>
<body>

<h1>Media Upload Test</h1>

<div class="box">
    <form method="post" enctype="multipart/form-data">
        <label>
            Choose file:
            <input type="file" name="file" required>
        </label>
        <button type="submit">Upload</button>
    </form>
    <p><small>This saves the file to a test upload folder and inserts a row into <code>media</code>.</small></p>
</div>

<?php if ($error): ?>
    <div class="box error">
        <h2>Error</h2>
        <pre><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></pre>
    </div>
<?php endif; ?>

<?php if ($result): ?>
    <div class="box ok">
        <h2>Inserted Media</h2>
        <pre><?= htmlspecialchars(print_r($result, true), ENT_QUOTES, 'UTF-8') ?></pre>
    </div>
<?php endif; ?>

</body>
</html>
