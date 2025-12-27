<?php

    namespace Site;

    use Site\Interfaces\iMediaDAO;

final class MediaDAO implements iMediaDAO
{
    protected $database;
    protected $conn;

    function __construct()
    {   
        $this->database = new Database();
        $this->database->connect();

        $this->conn = $this->database->getConnection();
    }

    public function getByID(int $id): ?Media
    {
        $sql = "SELECT *
        FROM personal_website.Media 
        WHERE id =  ?";

        $result = $this->conn->prepare($sql);
        $result->execute([$id]);
        $mediaInfo = $result -> fetch();  
        
        if (!$mediaInfo) {
            return null;
        }
        else {
            return new Media(
                $mediaInfo['id'],
                $mediaInfo['type'],
                $mediaInfo['mime_type'],
                $mediaInfo['original_name'],
                $mediaInfo['stored_name'],
                (int)$mediaInfo['size_bytes'],
                isset($mediaInfo['width']) ? (int)$mediaInfo['width'] : null,
                isset($mediaInfo['height']) ? (int)$mediaInfo['height'] : null,
                isset($mediaInfo['duration_seconds']) ? (float)$mediaInfo['duration_seconds'] : null,
                new \DateTimeImmutable($mediaInfo['created_at'])
            );
        }
    }

    public function insert(Media $media): Media
    {
        $sql = "INSERT INTO personal_website.media 
                (type, mime_type, original_name, stored_name, size_bytes, width, height, duration_seconds) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        try {
            $result = $this->conn->prepare($sql);

            $result->execute([
                $media->getType(),
                $media->getMimeType(),
                $media->getOriginalName(),
                $media->getStoredName(),
                $media->getSizeBytes(),
                $media->getWidth(),
                $media->getHeight(),
                $media->getDurationSeconds()
        ]);

        $media->assignID((int)$this->conn->lastInsertId());

        } catch (\PDOException $e) {
            throw $e;
        }                    
    
        return $media;
    }
    public function update(Media $media): void
    {
        $sql = "UPDATE personal_website.media 
                SET type = ?, mime_type = ?, original_name = ?, stored_name = ?, size_bytes = ?, width = ?, height = ?, duration_seconds = ?
                WHERE id = ?";

        try {
            $result = $this->conn->prepare($sql);

            $result->execute([
                $media->getType(),
                $media->getMimeType(),
                $media->getOriginalName(),
                $media->getStoredName(),
                $media->getSizeBytes(),
                $media->getWidth(),
                $media->getHeight(),
                $media->getDurationSeconds(),
                $media->getId()
            ]);
        } catch (\PDOException $e) {
            throw $e;
        }                    
    }

    public function deleteByID(int $id): void
    {
        $sql = "DELETE FROM personal_website.media WHERE id = ?";

        try {
            $result = $this->conn->prepare($sql);
            $result->execute([$id]);
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    public function fetchAll(): array
    {
        $sql = "SELECT *
        FROM personal_website.media";

        $result = $this->conn->prepare($sql);
        $result->execute();
        $mediaRecords = $result -> fetchAll();  
        
        $mediaList = [];
        foreach ($mediaRecords as $mediaInfo) {
            $mediaList[] = new Media(
                $mediaInfo['id'],
                $mediaInfo['type'],
                $mediaInfo['mime_type'],
                $mediaInfo['original_name'],
                $mediaInfo['stored_name'],
                (int)$mediaInfo['size_bytes'],
                isset($mediaInfo['width']) ? (int)$mediaInfo['width'] : null,
                isset($mediaInfo['height']) ? (int)$mediaInfo['height'] : null,
                isset($mediaInfo['duration_seconds']) ? (float)$mediaInfo['duration_seconds'] : null,
                new \DateTimeImmutable($mediaInfo['created_at'])
            );
        }

        return $mediaList;
    }
}

?>