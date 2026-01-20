<?php
namespace Site;

use Site\Interfaces\iMedia;

final class Media implements iMedia
{
    private ?int $id;
    private string $type;
    private string $mimeType;
    private string $originalName;
    private string $storedName;
     private string $storageKey; 
    private int $sizeBytes;

    private ?int $width;
    private ?int $height;
    private ?float $durationSeconds;

    private \DateTimeImmutable $createdAt;

    public function __construct(
        ?int $id,
        string $type,
        string $mimeType,
        string $originalName,
        string $storedName,
        int $sizeBytes,
        ?int $width = null,
        ?int $height = null,
        ?float $durationSeconds = null,
        ?\DateTimeImmutable $createdAt = null
    ) {
        // invariants
        if ($type === '') throw new \InvalidArgumentException('type required');
        if ($mimeType === '') throw new \InvalidArgumentException('mimeType required');
        if ($storedName === '') throw new \InvalidArgumentException('storedName required');
        if ($sizeBytes <= 0) throw new \InvalidArgumentException('sizeBytes must be > 0');

        if (($width !== null && $width <= 0) || ($height !== null && $height <= 0)) {
            throw new \InvalidArgumentException('width/height must be > 0 when provided');
        }

        if ($durationSeconds !== null && $durationSeconds <= 0) {
            throw new \InvalidArgumentException('duration must be > 0 when provided');
        }

        $this->id = $id;
        $this->type = $type;
        $this->mimeType = $mimeType;
        $this->originalName = $originalName;
        $this->storedName = $storedName;
        $this->sizeBytes = $sizeBytes;
        $this->width = $width;
        $this->height = $height;
        $this->durationSeconds = $durationSeconds;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }
    public function getType(): string { return $this->type; }
    public function getMimeType(): string { return $this->mimeType; }
    public function getOriginalName(): string { return $this->originalName; }
    public function getStoredName(): string { return $this->storedName; }
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