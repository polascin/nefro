<?php

if (!function_exists('npsCreateImageResourceFromFile')) {
    function npsCreateImageResourceFromFile(string $filePath, string $mime)
    {
        if ($mime === 'image/jpeg') {
            return @imagecreatefromjpeg($filePath);
        }
        if ($mime === 'image/png') {
            return @imagecreatefrompng($filePath);
        }
        if ($mime === 'image/gif') {
            return @imagecreatefromgif($filePath);
        }
        if ($mime === 'image/webp' && function_exists('imagecreatefromwebp')) {
            return @imagecreatefromwebp($filePath);
        }

        return false;
    }
}

if (!function_exists('npsResizeImageResource')) {
    function npsResizeImageResource($source, int $srcW, int $srcH, int $dstW, int $dstH, string $mime)
    {
        $canvas = imagecreatetruecolor($dstW, $dstH);
        if ($canvas === false) {
            return false;
        }

        if ($mime === 'image/png' || $mime === 'image/gif' || $mime === 'image/webp') {
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
            imagefilledrectangle($canvas, 0, 0, $dstW, $dstH, $transparent);
        }

        if (!imagecopyresampled($canvas, $source, 0, 0, 0, 0, $dstW, $dstH, $srcW, $srcH)) {
            imagedestroy($canvas);
            return false;
        }

        return $canvas;
    }
}

if (!function_exists('npsWriteImageWithLimit')) {
    function npsWriteImageWithLimit($image, string $destination, string $mime, int $maxFileSize): bool
    {
        $qualitySteps = [82, 74, 66, 58, 50, 42];

        if ($mime === 'image/jpeg') {
            foreach ($qualitySteps as $quality) {
                if (!imagejpeg($image, $destination, $quality)) {
                    continue;
                }
                clearstatcache(true, $destination);
                if (is_file($destination) && filesize($destination) <= $maxFileSize) {
                    return true;
                }
            }
            return false;
        }

        if ($mime === 'image/webp' && function_exists('imagewebp')) {
            foreach ($qualitySteps as $quality) {
                if (!imagewebp($image, $destination, $quality)) {
                    continue;
                }
                clearstatcache(true, $destination);
                if (is_file($destination) && filesize($destination) <= $maxFileSize) {
                    return true;
                }
            }
            return false;
        }

        if ($mime === 'image/png') {
            for ($compression = 6; $compression <= 9; $compression++) {
                if (!imagepng($image, $destination, $compression)) {
                    continue;
                }
                clearstatcache(true, $destination);
                if (is_file($destination) && filesize($destination) <= $maxFileSize) {
                    return true;
                }
            }
            return false;
        }

        if ($mime === 'image/gif') {
            if (!imagegif($image, $destination)) {
                return false;
            }
            clearstatcache(true, $destination);
            return is_file($destination) && filesize($destination) <= $maxFileSize;
        }

        return false;
    }
}

if (!function_exists('processAvatarUpload')) {
    /**
     * @return array{path:?string,error:?string}
     */
    function processAvatarUpload(array $file, int $maxFileSize = 2097152): array
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return ['path' => null, 'error' => null];
        }

        $tmpPath = (string) ($file['tmp_name'] ?? '');
        $fileSize = (int) ($file['size'] ?? 0);
        if ($tmpPath === '' || !is_uploaded_file($tmpPath) || $fileSize <= 0) {
            return ['path' => null, 'error' => 'Nahraný súbor je neplatný.'];
        }

        $imageMeta = @getimagesize($tmpPath);
        if ($imageMeta === false || empty($imageMeta[0]) || empty($imageMeta[1])) {
            return ['path' => null, 'error' => 'Nahraný súbor nie je validný obrázok.'];
        }

        $imgWidth = (int) $imageMeta[0];
        $imgHeight = (int) $imageMeta[1];
        $maxPixels = 25000000; // 25 MP
        $maxSide = 8000;
        if ($imgWidth > $maxSide || $imgHeight > $maxSide || ($imgWidth * $imgHeight) > $maxPixels) {
            return ['path' => null, 'error' => 'Obrázok má príliš veľké rozmery. Maximálne 8000x8000 px a 25 MP.'];
        }

        $mime = (string) mime_content_type($tmpPath);
        $mimeToExt = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
        ];

        if (!isset($mimeToExt[$mime])) {
            return ['path' => null, 'error' => 'Nepodporovaný formát avatara. Povolené sú JPG, PNG, GIF a WebP.'];
        }

        $uploadDir = __DIR__ . '/uploads/avatars/';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            return ['path' => null, 'error' => 'Nepodarilo sa pripraviť priečinok pre avatar.'];
        }

        $extension = $mimeToExt[$mime];
        $newFileName = uniqid('avatar_', true) . '.' . $extension;
        $destinationAbs = $uploadDir . $newFileName;
        $destinationRel = 'uploads/avatars/' . $newFileName;

        if ($fileSize <= $maxFileSize) {
            if (move_uploaded_file($tmpPath, $destinationAbs)) {
                return ['path' => $destinationRel, 'error' => null];
            }
            return ['path' => null, 'error' => 'Nastala chyba pri nahrávaní obrázka.'];
        }

        if (!extension_loaded('gd')) {
            return ['path' => null, 'error' => 'Obrázok je väčší ako 2 MB a server nepodporuje automatické zmenšenie (chýba GD).'];
        }

        $source = npsCreateImageResourceFromFile($tmpPath, $mime);
        if ($source === false) {
            return ['path' => null, 'error' => 'Nepodarilo sa spracovať nahraný obrázok.'];
        }

        $srcW = imagesx($source);
        $srcH = imagesy($source);
        $maxDimension = 1600;
        $fitScale = min(1, $maxDimension / max($srcW, $srcH));

        $written = false;
        for ($attempt = 0; $attempt < 6; $attempt++) {
            $scale = $fitScale * pow(0.85, $attempt);
            $dstW = max(1, (int) round($srcW * $scale));
            $dstH = max(1, (int) round($srcH * $scale));

            $workImage = npsResizeImageResource($source, $srcW, $srcH, $dstW, $dstH, $mime);
            if ($workImage === false) {
                continue;
            }

            $written = npsWriteImageWithLimit($workImage, $destinationAbs, $mime, $maxFileSize);
            imagedestroy($workImage);

            if ($written) {
                break;
            }
        }

        imagedestroy($source);

        if (!$written) {
            if (is_file($destinationAbs)) {
                @unlink($destinationAbs);
            }
            return ['path' => null, 'error' => 'Obrázok sa nepodarilo automaticky zmenšiť pod 2 MB. Skúste menší súbor.'];
        }

        return ['path' => $destinationRel, 'error' => null];
    }
}
