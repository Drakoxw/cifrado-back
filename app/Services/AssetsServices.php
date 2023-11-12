<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Classes\DTOs\ResponseData;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AssetsServices
{
    const URL_BASE = 'https://cifrado.com.co/sound-lab/assets';

    private static function routeBase(string $path)
    {
        return Str::replace('//', '/', dirname(__FILE__) . "/../../../sound-lab/assets/$path");
    }

    public static function allowedExtensions(): array {
        return ['PNG', 'JPG', 'JPEG', 'JFIF', 'WEBP', 'GIF', 'ICO'];
    }

    public static function existFile(string $path): bool
    {
        $ruta = self::routeBase("") . $path;
        return file_exists($ruta);
    }

    public static function listImages(): array
    {
        $rutaBase = self::routeBase("");
        $estructura = [];
        $archivos = File::allFiles($rutaBase);

        foreach ($archivos as $archivo) {
            $info = [];
            $isImg = false;
            if (in_array(strtoupper($archivo->getExtension()), self::allowedExtensions())) {
                $info = getimagesize($archivo->getPathname());
                $isImg = true;
            }
            $estructura[] = [
                'url'       => self::URL_BASE . '/' . Str::replace('\\', '/', $archivo->getRelativePathname()),
                'path'      => Str::replace('\\', '/',$archivo->getRelativePathname()),
                'name'      => $archivo->getFilename(),
                'file'      => Str::replace('\\', '/',$archivo->getRelativePath()),
                'extension' => $archivo->getExtension(),
                'weight'    => number_format($archivo->getSize() / 1000, 1) . ' KB',
                'date'      =>  date('Y-m-d H:i:s', $archivo->getCTime()),
                'isImage'   => $isImg,
                'width'     => $info[0] ?? 0,
                'height'    => $info[1] ?? 0,
                'mimeType'  => $info['mime'] ?? '',
            ];
        }

        return $estructura;
    }

    public static function deleteImage(string $path): ResponseData
    {
        $res = new ResponseData(false, 'proccess', []);
        $ruta = self::routeBase("") . $path;

        if (file_exists($ruta)) {
            unlink($ruta);
            $res->success = true;
            $res->message = 'Imagen eliminada';
            $res->data = $path;
        } else {
            $res->success = false;
            $res->message = 'Imagen no encontrada';
            $res->data = $path;
        }
        return $res;
    }

    public static function replaceImage(string $base64, string $path, int $quality = 80): ResponseData
    {
        $res = new ResponseData(false, 'proccess', []);
        $ruta = self::routeBase("") . $path;

        if (!file_exists($ruta)){
            $res->success = false;
            $res->message = 'Imagen no encontrada';
            $res->data = $path;
            return $res;
        }

        $base = self::optimizeImage(self::clearBase64($base64), $quality);

        if ($fp = fopen($ruta, 'w')) {
            fwrite($fp, $base);
            fclose($fp);

            $res->success = true;
            $res->message = 'Imagen guardada';
            $res->data = $path;
        } else {
            $res->success = false;
            $res->message = 'No se pudo abrir la imagen';
            $res->data = $path;
        }
        return $res;
    }

    public static function saveImages(string $base64, string $name): ResponseData
    {
        $res = new ResponseData(false, 'proccess', []);

        $random = Str::random(10);
        $rutaBase = self::routeBase("store/images");
        if (!file_exists($rutaBase)) {
            mkdir($rutaBase, 0755, true);
        }

        $base = self::optimizeImage(self::clearBase64($base64), 60);
        $rutaCompleta = $rutaBase . "/$random-$name";
        if ($fp = fopen($rutaCompleta, 'w')) {
            fwrite($fp, $base);
            fclose($fp);

            $res->success = true;
            $res->message = 'Imagen guardada';
            $res->data = ['path' => self::PathToFront($rutaCompleta)];
        } else {
            $res->message = 'Error al guardar imagen';
        }

        return $res;
    }

    static private function PathToFront(string $pathAbsolut): string
    {
        $rutaSplit = explode('assets', $pathAbsolut);
        if (isset($rutaSplit[1])) {
            return self::URL_BASE. $rutaSplit[1];
        }
        return '';
    }

    static private function clearBase64(string $base): string
    {
        $baseSplit = explode(',', $base);
        if (isset($baseSplit[1])) {
            return $baseSplit[1];
        }
        return $base;
    }

    public static function optimizeImage(string $binary, int $quality = 60)
    {
        // Ruta donde se guardará la imagen optimizada
        $time = time();
        $optimizedImagePath = Storage::path("public/temp/$time-optimizada.png");

        // Carga la imagen original
        $image = Image::make($binary);

        // Optimiza la imagen (puedes ajustar la calidad según tus necesidades)
        $image->encode('png', $quality)->save($optimizedImagePath);

        $imgBin = file_get_contents($optimizedImagePath);
        unlink($optimizedImagePath);

        return $imgBin;
    }


    /*
    * Función personalizada para comprimir y
    * subir una imagen mediante PHP
    */
    public static function compressImage($source, $destination, $quality)
    {
        // Obtenemos la información de la imagen
        $imgInfo = getimagesize($source);
        $mime = $imgInfo['mime'];

        // Creamos una imagen
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            default:
                $image = imagecreatefromjpeg($source);
        }

        // Guardamos la imagen
        imagejpeg($image, $destination, $quality);

        // Devolvemos la imagen comprimida
        return $destination;
    }
}
