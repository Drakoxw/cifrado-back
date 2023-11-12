<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\UserCifradoModel;

class UserTest extends TestCase
{

    public function test_register_user()
    {
        $id = UserCifradoModel::Register('UserTest', 'PassworSecret12345');
        print_r($id);
        UserCifradoModel::destroy($id);
        $this->assertIsInt($id);
    }

    public function test_validate_login()
    {
        $user = 'UserTest';
        $pass = 'PassworSecret12345';
        $user = UserCifradoModel::GetUser($user, $pass);
        $this->assertIsObject($user);
        $this->assertIsInt($user->id);
    }
}
