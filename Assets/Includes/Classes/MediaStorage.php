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
        return $this->rootDir . '/' . $key;
        
    }

    public function saveUploadedFile(array $file, string $storageKey): void
    {
        $dest = $this->pathFor($storageKey);
        $dir  = dirname($dest);

        // Verify it's a real PHP upload
        if (empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            throw new \RuntimeException('Temp file is not a valid uploaded file: ' . ($file['tmp_name'] ?? 'missing'));
        }

        // Create year/month folder path if missing (fail loudly)
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0755, true) && !is_dir($dir)) {
                $err = error_get_last();
                throw new \RuntimeException(
                    "Failed to create directory: $dir. Last error: " . ($err['message'] ?? 'unknown')
                );
            }
        }

        // Ensure writable
        if (!is_writable($dir)) {
            throw new \RuntimeException("Upload directory not writable: $dir");
        }

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            $err = error_get_last();
            throw new \RuntimeException(
                'Failed to move uploaded file ' . $file['tmp_name'] . ' to ' . $dest .
                '. Last error: ' . ($err['message'] ?? 'unknown')
            );
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