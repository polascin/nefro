<?php

declare(strict_types=1);

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

if (!function_exists('npsIniBytes')) {
    function npsIniBytes(string $value): int
    {
        $value = trim($value);
        if ($value === '' || $value === '-1') {
            return -1;
        }
        $unit = strtolower(substr($value, -1));
        $number = (float) $value;
        return match ($unit) {
            'g' => (int) ($number * 1024 * 1024 * 1024),
            'm' => (int) ($number * 1024 * 1024),
            'k' => (int) ($number * 1024),
            default => (int) $number,
        };
    }
}

if (!function_exists('npsApplyExifOrientation')) {
    /** Aplikuje EXIF orientáciu JPEG pred novým zakódovaním bez metadát. */
    function npsApplyExifOrientation($source, string $filePath, string $mime)
    {
        if ($mime !== 'image/jpeg' || !function_exists('exif_read_data')) {
            return $source;
        }

        $exif = @exif_read_data($filePath, 'IFD0', true, false);
        $orientation = is_array($exif)
            ? (int) ($exif['IFD0']['Orientation'] ?? $exif['Orientation'] ?? 1)
            : 1;

        if ($orientation === 2) {
            imageflip($source, IMG_FLIP_HORIZONTAL);
        } elseif ($orientation === 3) {
            $rotated = imagerotate($source, 180, 0);
            if ($rotated !== false) {
                imagedestroy($source);
                $source = $rotated;
            }
        } elseif ($orientation === 4) {
            imageflip($source, IMG_FLIP_VERTICAL);
        } elseif (in_array($orientation, [5, 6, 7, 8], true)) {
            if ($orientation === 5 || $orientation === 7) {
                imageflip($source, IMG_FLIP_HORIZONTAL);
            }
            $degrees = in_array($orientation, [5, 6], true) ? 270 : 90;
            $rotated = imagerotate($source, $degrees, 0);
            if ($rotated !== false) {
                imagedestroy($source);
                $source = $rotated;
            }
        }

        return $source;
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

        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $dstW, $dstH, $srcW, $srcH);

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
        $uploadError = (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE);
        if ($uploadError === UPLOAD_ERR_NO_FILE) {
            return ['path' => null, 'error' => null];
        }
        if ($uploadError !== UPLOAD_ERR_OK) {
            $message = in_array($uploadError, [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)
                ? 'Nahraný obrázok prekračuje povolenú veľkosť servera.'
                : 'Nahrávanie obrázka sa nepodarilo. Skúste to znova.';
            return ['path' => null, 'error' => $message];
        }

        $tmpPath = (string) ($file['tmp_name'] ?? '');
        if ($tmpPath === '' || !is_uploaded_file($tmpPath)) {
            return ['path' => null, 'error' => 'Nahraný súbor je neplatný.'];
        }
        $actualFileSize = filesize($tmpPath);
        if ($actualFileSize === false || $actualFileSize <= 0) {
            return ['path' => null, 'error' => 'Nahraný súbor je prázdny alebo sa nedá prečítať.'];
        }
        if ($actualFileSize > $maxFileSize) {
            return ['path' => null, 'error' => 'Nahraný obrázok prekračuje maximálnu veľkosť 2 MB.'];
        }
        $imageMeta = @getimagesize($tmpPath);
        if ($imageMeta === false || empty($imageMeta[0]) || empty($imageMeta[1])) {
            return ['path' => null, 'error' => 'Nahraný súbor nie je validný obrázok.'];
        }

        $imgWidth = (int) $imageMeta[0];
        $imgHeight = (int) $imageMeta[1];
        $maxPixels = 8000000; // Avatary sa ukladajú najviac ako 1600 px.
        $maxSide = 4096;
        $pixelLimitExceeded = $imgHeight <= 0 || $imgWidth > intdiv($maxPixels, $imgHeight);
        $targetScale = min(1, 1600 / max($imgWidth, $imgHeight));
        $targetPixels = max(1, (int) round($imgWidth * $targetScale))
            * max(1, (int) round($imgHeight * $targetScale));
        // Konzervatívny odhad GD: RGBA pixely + interná réžia zdroja/cieľa.
        $estimatedDecodeBytes = ($imgWidth * $imgHeight * 6) + ($targetPixels * 6) + (8 * 1024 * 1024);
        $memoryLimit = npsIniBytes((string) ini_get('memory_limit'));
        $availableMemory = $memoryLimit > 0
            ? max(0, $memoryLimit - memory_get_usage(true) - (16 * 1024 * 1024))
            : 80 * 1024 * 1024;
        $decodeBudget = min(80 * 1024 * 1024, $availableMemory);
        if ($imgWidth > $maxSide || $imgHeight > $maxSide || $pixelLimitExceeded || $estimatedDecodeBytes > $decodeBudget) {
            return ['path' => null, 'error' => 'Obrázok má príliš veľké rozmery na bezpečné spracovanie. Maximum je 4096 px na stranu a 8 MP.'];
        }

        $mime = (string) mime_content_type($tmpPath);
        $imageMime = (string) $imageMeta['mime'];
        $mimeToExt = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
        ];

        if (!isset($mimeToExt[$mime]) || $imageMime !== $mime) {
            return ['path' => null, 'error' => 'Nepodporovaný formát avatara. Povolené sú JPG, PNG, GIF a WebP.'];
        }

        $uploadDir = __DIR__ . '/uploads/avatars/';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            return ['path' => null, 'error' => 'Nepodarilo sa pripraviť priečinok pre avatar.'];
        }
        $htaccessPath = $uploadDir . '.htaccess';
        if (!is_file($htaccessPath)) {
            @file_put_contents($htaccessPath,
                "<FilesMatch \"\\.php[0-9]?$\">\n    Require all denied\n</FilesMatch>\nOptions -ExecCGI\nphp_flag engine off\n"
            );
        }

        $extension = $mimeToExt[$mime];
        $newFileName = 'avatar_' . bin2hex(random_bytes(16)) . '.' . $extension;
        $destinationAbs = $uploadDir . $newFileName;
        $destinationRel = 'uploads/avatars/' . $newFileName;

        if (!extension_loaded('gd')) {
            return ['path' => null, 'error' => 'Server nepodporuje bezpečné spracovanie obrázka (chýba GD).'];
        }

        $source = npsCreateImageResourceFromFile($tmpPath, $mime);
        if ($source === false) {
            return ['path' => null, 'error' => 'Nepodarilo sa spracovať nahraný obrázok.'];
        }
        $source = npsApplyExifOrientation($source, $tmpPath, $mime);

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

if (!function_exists('deleteManagedAvatarFile')) {
    /** Odstráni iba súbor, ktorého reálna cesta ostáva v spravovanom adresári avatarov. */
    function deleteManagedAvatarFile(?string $relativePath): bool
    {
        if ($relativePath === null || trim($relativePath) === '') {
            return true;
        }

        $uploadsRoot = realpath(__DIR__ . '/uploads/avatars');
        $candidate = realpath(__DIR__ . '/' . ltrim(str_replace('\\', '/', $relativePath), '/'));
        if ($uploadsRoot === false || $candidate === false
            || !str_starts_with($candidate, $uploadsRoot . DIRECTORY_SEPARATOR)
        ) {
            return false;
        }

        return !is_file($candidate) || @unlink($candidate);
    }
}
