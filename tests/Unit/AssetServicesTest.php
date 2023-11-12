<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\AssetsServices;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AssetServicesTest extends TestCase
{

    public function test_eliminar_imagen()
    {
        $path = 'dev/api.php';
        if (AssetsServices::existFile($path)) {
            $resp = AssetsServices::deleteImage($path);
            $this->assertTrue($resp->success);
        }
        $this->assertIsString($path);
    }

    public function test_listar_imagenes()
    {
        $imgs = AssetsServices::listImages();
        $this->assertIsArray($imgs);
        print_r($imgs);
    }

    public function test_guardar_imagenes()
    {
        $img = file_get_contents('https://sound-lab.com.co/assets/icons/whatsapp.png');
        $base64 = base64_encode($img);
        $res = AssetsServices::saveImages($base64, 'whatsapp.png');
        $this->assertTrue($res->success);
    }

    public function test_optimizar_imagenes()
    {
        $img = file_get_contents('https://sound-lab.com.co/assets/icons/whatsapp.png');
        $res = AssetsServices::optimizeImage($img);
        $this->assertIsString($res);
    }

    public function test_plantillas()
    {
        $new = Storage::path("public/temp/test.png");
        $plantilla = Storage::get('public/PlantillaBlanca.png');
        $client = Storage::get('public/x.png');

        $image = Image::make($client);
        $image->insert($plantilla , 'center');
        $image->encode('png', 60)->save($new);
        $this->assertTrue(true);
        /*
        // create new Intervention Image
        $img = Image::make('public/foo.jpg');

        // paste another image
        $img->insert('public/bar.png');

        // create a new Image instance for inserting
        $watermark = Image::make('public/watermark.png');
        $img->insert($watermark, 'center');

        // insert watermark at bottom-right corner with 10px offset
        $img->insert('public/watermark.png', 'bottom-right', 10, 10);
        */
    }

}
