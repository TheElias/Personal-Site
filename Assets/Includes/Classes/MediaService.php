<?php
declare(strict_types=1);

namespace Site;

use Site\Interfaces\iMediaService;

final class MediaService implements iMediaService
{
    public function __construct(
        private MediaDAO $mediaDao,
        private MediaStorage $storage
    ) {}

    /**
     * Upload a file and create a Media DB record.
     *
     * @param array $file A single entry from $_FILES['whatever']
     * @param string $typeHint Optional hint: 'image','audio','video','document','auto'
     */
    public function upload(array $file, string $typeHint = 'auto'): Media
    {
        // 1) Basic upload checks (don’t trust user input)
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            throw new \RuntimeException('Upload failed. PHP error code: ' . ($file['error'] ?? 'unknown'));
        }

        if (empty($file['tmp_name']) || !is_file($file['tmp_name'])) {
            throw new \RuntimeException('Upload temp file missing.');
        }

        $originalName = (string)($file['name'] ?? 'upload');

        // 2) Generate storage key BEFORE DB insert
        $storageKey = $this->generateStorageKey($originalName);

        var_dump("Storage Key: " . $storageKey . " Original Name: " . $originalName);
        // 3) Save bytes to disk
        $this->storage->saveUploadedFile($file, $storageKey);

        // From here on, if anything fails, delete the stored file.
        try {
            $fullPath = $this->storage->pathFor($storageKey);

            // 4) Server-side mime sniff (don’t trust $_FILES['type'])
            $mimeType = $this->detectMimeType($fullPath);

            // 5) Determine normalized type (image/audio/video/document)
            $type = $this->normalizeType($typeHint, $mimeType);

            // 6) True size from disk
            $sizeBytes = $this->fileSizeOrFail($fullPath);

            // 7) Optional metadata
            [$width, $height] = $this->imageDimensionsIfAny($fullPath, $mimeType);
            $durationSeconds = null; // keep null until you implement audio/video inspection

            // 8) Create Media entity (id null until insert)
            $media = new Media(
                null,
                $type,
                $mimeType,
                $originalName,
                $storageKey,
                $sizeBytes,
                $width,
                $height,
                $durationSeconds,
                new \DateTimeImmutable('now')
            );

            // 9) Insert DB row (DAO assigns ID)
            return $this->mediaDao->insert($media);

        } catch (\Throwable $e) {
            // Cleanup: avoid orphaned files
            $this->storage->delete($storageKey);
            throw $e;
        }
    }

    // -------------------------
    // Helper methods (private)
    // -------------------------

    private function generateStorageKey(string $originalName): string
    {
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $uuid = bin2hex(random_bytes(16)); // 128-bit random
        $ym = (new \DateTimeImmutable())->format('Y/m');

        return "media/{$ym}/{$uuid}" . ($ext ? ".{$ext}" : "");
    }

    private function detectMimeType(string $fullPath): string
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($fullPath);

        return $mime ?: 'application/octet-stream';
    }

    private function normalizeType(string $typeHint, string $mimeType): string
    {
        if ($typeHint !== 'auto') {
            return $typeHint;
        }

        if (str_starts_with($mimeType, 'image/')) return 'image';
        if (str_starts_with($mimeType, 'audio/')) return 'audio';
        if (str_starts_with($mimeType, 'video/')) return 'video';

        // common docs
        if ($mimeType === 'application/pdf') return 'document';

        return 'document';
    }

    private function fileSizeOrFail(string $fullPath): int
    {
        $size = @filesize($fullPath);
        if ($size === false) {
            throw new \RuntimeException('Could not read file size.');
        }
        return (int)$size;
    }

    /**
     * Returns [width,height] or [null,null] if not an image or unreadable.
     */
    private function imageDimensionsIfAny(string $fullPath, string $mimeType): array
    {
        if (!str_starts_with($mimeType, 'image/')) {
            return [null, null];
        }

        // getimagesize verifies it’s a real image and gives dimensions
        $info = @getimagesize($fullPath);
        if (!$info) {
            // MIME said image, but content isn't parseable as an image → reject
            throw new \RuntimeException('File claims to be an image, but image parsing failed.');
        }

        return [(int)$info[0], (int)$info[1]];
    }
}
