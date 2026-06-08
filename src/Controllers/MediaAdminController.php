<?php

namespace Site\Controllers;

use Site\Auth\AuthGuard;
use Site\Media\MediaService;

class MediaAdminController
{
    public function __construct(
        private AuthGuard $authGuard,
        private MediaService $mediaService
    ) {}

    public function mediaAdmin(): void
    {
        $this->authGuard->requireLogin();

        $mediaItems = $this->mediaService->getAllMedia();

        require VIEW_PATH . '/admin/Media/mediaAdmin.php';
    }

    public function mediaUpload(): void
    {
        $this->authGuard->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            // Handle GET request or other methods
            return;
        }

        try {
            $media = $this->mediaService->upload($_FILES['file']); // returns Media with ID assigned

            $successMessage = 'Upload successful';

        } catch (\Throwable $e) {
            $errorMessage = 'Unexpected error: ' . $e->getMessage();
        }

        require VIEW_PATH . '/admin/Media/mediaAdmin.php';
    }

    public function getAllMedia(): array
    {
        return $this->mediaService->getAllMedia();
    }
}
