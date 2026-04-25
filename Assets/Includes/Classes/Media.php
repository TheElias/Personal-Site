<?php
namespace Site;

use Site\Interfaces\iMedia;

final class Media implements iMedia
{
    private ?int $id;
    private string $type;
    private string $mimeType;
    private string $original_filename;
    private string $stored_filename;
    private string $extension;
    private string $storageKey; 
    private int $sizeBytes;

    private ?int $width;
    private ?int $height;
    private ?float $durationSeconds;

    private const ALLOWED_MIME = [
    // Images (download or inline ok)
    'image/jpeg',
    'image/png',
    'image/webp',
    'image/gif',

    // Plain text / code (download only)
    'text/plain',
    'text/html',
    'text/css',
    'application/javascript',
    'application/json',
    'application/xml',
    'text/xml',
    'text/csv',
    'text/php',

    // Documents
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/vnd.ms-powerpoint',
    'application/vnd.openxmlformats-officedocument.presentationml.presentation',

    // Audio
    'audio/mpeg',
    'audio/wav',
    'audio/ogg',
    'audio/webm',

    // Video
    'video/mp4',
    'video/webm',

    // Archives
    'application/zip',
    ];

    private \DateTimeImmutable $createdAt;

    public function __construct(
        ?int $id,
        string $type,
        string $mimeType,
        string $original_filename,
        string $stored_filename,
        int $sizeBytes,
        ?int $width = null,
        ?int $height = null,
        ?float $durationSeconds = null,
        ?\DateTimeImmutable $createdAt = null
    ) {
        // invariants
        if ($type === '') throw new \InvalidArgumentException('type required');
        if ($mimeType === '') throw new \InvalidArgumentException('mimeType required');

        if (!in_array($mimeType, self::ALLOWED_MIME, true)) {
            throw new \InvalidArgumentException("Unsupported MIME type: {$mimeType}");
        }

        if ($original_filename === '') throw new \InvalidArgumentException('original_filename required');
        if ($stored_filename === '') throw new \InvalidArgumentException('stored_filename required');

        if ($sizeBytes <= 0) throw new \InvalidArgumentException('sizeBytes must be > 0');

        $ext = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));
        $ext = $ext === '' ? null : $ext;

        if ($ext === null) {
            throw new \InvalidArgumentException('File extension could not be determined from original filename');
        }

        if (($width !== null && $width <= 0) || ($height !== null && $height <= 0)) {
            throw new \InvalidArgumentException('width/height must be > 0 when provided');
        }

        if ($durationSeconds !== null && $durationSeconds <= 0) {
            throw new \InvalidArgumentException('duration must be > 0 when provided');
        }

        $this->id = $id;
        $this->type = $type; 
        $this->mimeType = $mimeType;
        $this->original_filename = $original_filename;
        $this->stored_filename = $stored_filename;       

        $this->extension = $ext;

        $this->sizeBytes = $sizeBytes;
        $this->width = $width;
        $this->height = $height;
        $this->durationSeconds = $durationSeconds;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }
    public function getType(): string { return $this->type; }
    public function getMimeType(): string { return $this->mimeType; }
    public function getOriginalName(): string { return $this->original_filename; }
    public function getStoredName(): string { return $this->stored_filename; }
    public function getExtension(): string { return $this->extension; }
    public function getSizeBytes(): int { return $this->sizeBytes; }

    public function getWidth(): ?int { return $this->width; }
    public function getHeight(): ?int { return $this->height; }
    public function getDurationSeconds(): ?float { return $this->durationSeconds; }

    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }

    public function isImage(): bool { return $this->type === 'image'; }
    public function isAudio(): bool { return $this->type === 'audio'; }
    public function isVideo(): bool { return $this->type === 'video'; }
    public function isDocument(): bool { return $this->type === 'document'; }

    public function hasDimensions(): bool { return $this->width !== null && $this->height !== null; }
    public function hasDuration(): bool { return $this->durationSeconds !== null; }

    public function assignID(int $id): void
    {
        if ($this->id !== null) {
            throw new \LogicException('ID is already set and cannot be changed.');
        }
        $this->id = $id;
    }
}
    
    ?>