<?php

namespace Site\Interfaces;

interface iMedia {

    public function getId(): ?int;
    public function getType(): string ;
    public function getMimeType(): string;
    public function getOriginalName(): string;
    public function getStoredName(): string;
    public function getSizeBytes(): int;

    public function getWidth(): ?int ;
    public function getHeight(): ?int;
    public function getDurationSeconds(): ?float;

    public function getCreatedAt(): \DateTimeImmutable;

    public function isImage(): bool;
    public function isAudio(): bool;
    public function isVideo(): bool;
    public function isDocument(): bool;

    public function hasDimensions(): bool;
    public function hasDuration(): bool;

    public function assignID(int $id): void;
}
?>

