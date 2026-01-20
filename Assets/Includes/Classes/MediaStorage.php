<?php

    namespace Site;

    use Site\Interfaces\iMediaStorage;

final class MediaStorage implements iMediaStorage
{
    public function __construct(private string $rootDir) {}

    public function pathFor(string $storageKey): string
    {
        $key = ltrim($storageKey, '/');

        if (str_contains($key, '..')) {
            throw new \InvalidArgumentException('Invalid storage key');
        }

        var_dump($this->rootDir . '  -  ' . $key);
        
        return '\n' . $this->rootDir . '/' . $key;
        
    }

    public function saveUploadedFile(array $file, string $storageKey): void
    {
        $dest = $this->pathFor($storageKey);
        $dir = dirname($dest);

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            throw new \RuntimeException('Failed to move uploaded file -' . $file['tmp_name'] . ' to ' . $dest);
        }
    }

    public function delete(string $storageKey): void
    {
        $path = $this->pathFor($storageKey);
        if (is_file($path)) {
            unlink($path);
        }
    }
}


?>