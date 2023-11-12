<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

define('UserCifrado', 'user_cifrado');
class UserCifradoModel extends Model
{
    use HasFactory, SoftDeletes;

    static $name = UserCifrado;

    protected $table = UserCifrado;

    protected $fields = [
        'id',
        'user',
        'password',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function Register(string $user, string $password): int {
        $data = [
            'user' => $user,
            'password' => hash("sha512", $password),
            'updated_at' => Carbon::now()
        ];
        return DB::table(UserCifrado)->insertGetId($data);
    }

    public static function GetUser(string $user, string $password) {
        $passHash = hash("sha512", $password);
        return DB::table(UserCifrado)
            ->where('user', $user)
            ->where('password', $passHash)
            ->where('deleted_at', null)
            ->first([
                'id',
                'user'
            ])
        ;
    }
}

/*
CREATE TABLE `cifrados_dev`.`user_cifrado` (`id` INT NOT NULL AUTO_INCREMENT , `user` VARCHAR(50) NULL , `password` VARCHAR(300) NULL , `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `updated_at` DATETIME NOT NULL , `deleted_at` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
TABLE `user_cifrado` ADD INDEX(`user`);
TABLE `user_cifrado` ADD INDEX(`password`);
TABLE `user_cifrado` ADD INDEX(`deleted_at`);
ALTER TABLE `user_cifrado` CHANGE `deleted_at` `deleted_at` DATETIME NULL;
*/
