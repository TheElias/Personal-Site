<?php
namespace Site\Interfaces;

use Site\Media;

interface iMediaService {
    public function upload(array $file, string $typeHint = 'auto'): Media;
}
?>

