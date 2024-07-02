<?php
header('Content-Type: application/json');

function getGalleryImages($meetupId) {
    $galleryPath = __DIR__ . "/assets/meetups/$meetupId/images/gallery";
    $images = [];

    if (is_dir($galleryPath)) {
        $files = scandir($galleryPath);
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        foreach ($files as $file) {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($extension, $allowedExtensions)) {
                $images[] = $file;
            }
        }
    }

    return $images;
}

$meetupId = $_GET['meetupId'] ?? '';

if (empty($meetupId)) {
    http_response_code(400);
    echo json_encode(['error' => 'Meetup ID is required']);
    exit;
}

$galleryImages = getGalleryImages($meetupId);
echo json_encode(['images' => $galleryImages]);