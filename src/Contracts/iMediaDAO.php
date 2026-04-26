<?php

namespace Site\Interfaces;

Use Site\Media;

interface iMediaDAO {

    public function getByID(int $id): ?Media;

    public function insert(Media $media): Media;
    public function update(Media $media): void;
    public function deleteByID(int $id): void;

    public function fetchAll(): array;
}
?>

