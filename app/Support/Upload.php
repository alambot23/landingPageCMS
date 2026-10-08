<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/** Simpan gambar ke disk "public"; bila GD tersedia, perkecil + ubah ke WebP agar ringan. */
class Upload
{
    public static function simpan(UploadedFile $file, string $dir, int $lebarMaks = 1600): string
    {
        try {
            if (extension_loaded('gd') && function_exists('imagewebp')) {
                $mime = $file->getMimeType();
                $path = $file->getRealPath();
                $img = match ($mime) {
                    'image/jpeg' => @imagecreatefromjpeg($path),
                    'image/png'  => @imagecreatefrompng($path),
                    'image/webp' => @imagecreatefromwebp($path),
                    default      => false,
                };
                if ($img) {
                    if ($mime === 'image/jpeg' && function_exists('exif_read_data')) {
                        $o = @exif_read_data($path)['Orientation'] ?? 1;
                        $sudut = [3 => 180, 6 => -90, 8 => 90][$o] ?? 0;
                        if ($sudut) {
                            $img = imagerotate($img, $sudut, 0);
                        }
                    }
                    if (imagesx($img) > $lebarMaks) {
                        $img = imagescale($img, $lebarMaks);
                    }
                    imagepalettetotruecolor($img);
                    imagealphablending($img, true);
                    imagesavealpha($img, true);
                    ob_start();
                    imagewebp($img, null, 82);
                    $bin = ob_get_clean();
                    $nama = trim($dir, '/') . '/' . Str::random(24) . '.webp';
                    Storage::disk('public')->put($nama, $bin);

                    return $nama;
                }
            }
        } catch (\Throwable $e) {
            // jatuh ke penyimpanan biasa di bawah
        }

        return $file->store($dir, 'public');
    }

    public static function hapus(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
