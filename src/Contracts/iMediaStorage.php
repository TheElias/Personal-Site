<?php

namespace Site\Interfaces;

interface iMediaStorage {
    public function pathFor(string $storageKey): string;
    public function saveUploadedFile(array $file, string $storageKey): void;
    public function delete(string $storageKey): void;
}
?>

