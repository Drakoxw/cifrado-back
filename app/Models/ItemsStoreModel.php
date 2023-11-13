<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

define('TblItems', 'tbl_items_store');
class ItemsStoreModel extends Model
{
    use HasFactory;

    static $name = TblItems;

    protected $table = TblItems;

    protected $fields = [
        'id',
        'name',
        'description',
        'tags',
        'main_image',
        'other_images',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Mutador para la columna 'tags'
    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = json_encode($value);
    }

    // Mutador para la columna 'other_images'
    public function setOtherImagesAttribute($value)
    {
        $this->attributes['other_images'] = json_encode($value);
    }

    // Accesor para la columna 'tags'
    public function getTagsAttribute($value)
    {
        return json_decode($value, true);
    }

    // Accesor para la columna 'other_images'
    public function getOtherImagesAttribute($value)
    {
        return json_decode($value, true);
    }
}

/*
CREATE TABLE `cifrados_dev`.`tbl_items_store` (
    `id` INT NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(255) NOT NULL ,
    `description` VARCHAR(500) NOT NULL ,
    `tags` VARCHAR(1200) NOT NULL ,
    `main_image` VARCHAR(255) NOT NULL ,
    `other_images` VARCHAR(1500) NOT NULL ,
    `user_id` INT NOT NULL ,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    `updated_at` DATETIME NULL DEFAULT NULL ,
    `deleted_at` DATETIME NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
*/
