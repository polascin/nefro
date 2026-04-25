Add-Type -AssemblyName System.Drawing
$imgPath = Join-Path $PWD "img\nps.gif"

if (-not (Test-Path $imgPath)) {
    Write-Host "Image not found at $imgPath"
    exit 1
}

$img = [System.Drawing.Image]::FromFile($imgPath)
$sizes = @(16, 32, 180, 192, 512)

foreach ($size in $sizes) {
    $bmp = New-Object System.Drawing.Bitmap($size, $size)
    $g = [System.Drawing.Graphics]::FromImage($bmp)
    $g.InterpolationMode = [System.Drawing.Drawing2D.InterpolationMode]::HighQualityBicubic
    $g.DrawImage($img, 0, 0, $size, $size)
    $g.Dispose()
    
    if ($size -eq 16) {
        $bmp.Save((Join-Path $PWD "favicon-16x16.png"), [System.Drawing.Imaging.ImageFormat]::Png)
    } elseif ($size -eq 32) {
        $bmp.Save((Join-Path $PWD "favicon-32x32.png"), [System.Drawing.Imaging.ImageFormat]::Png)
        $bmp.Save((Join-Path $PWD "favicon.ico"), [System.Drawing.Imaging.ImageFormat]::Icon)
    } elseif ($size -eq 180) {
        $bmp.Save((Join-Path $PWD "apple-touch-icon.png"), [System.Drawing.Imaging.ImageFormat]::Png)
    } elseif ($size -eq 192) {
        $bmp.Save((Join-Path $PWD "android-chrome-192x192.png"), [System.Drawing.Imaging.ImageFormat]::Png)
    } elseif ($size -eq 512) {
        $bmp.Save((Join-Path $PWD "android-chrome-512x512.png"), [System.Drawing.Imaging.ImageFormat]::Png)
    }
}
$img.Dispose()
Write-Host "Favicons generated successfully."
