<?php

namespace tests\Unit;

use tests\TestCase;

use App\Core\{Router, Request, App};

class UnitTest extends TestCase
{
    /** @test */
    public function config_is_not_empty()
    {
        $this->assertNotEmpty(App::get('config'));
    }

    /** @test */
    public function users_store()
    {
        $testUser = App::get('database')->insert('users', [
            'name' => 'TestUser'
        ]);
        $secondUser = App::get('database')->insert('users', [
            'name' => 'SecondUser'
        ]);

        $this->assertTrue($testUser);
        $this->assertTrue($secondUser);
    }

    /** @test */
    public function users_index()
    {
        $users = App::get('database')->selectAll('users');
        $this->assertNotEmpty($users);
    }

    /** @test */
    public function user_show()
    {
        $user = App::get('database')->selectAllWhere('users', [
            ['name', '=', 'TestUser'],
        ]);
        $this->assertNotEmpty($user);
    }

    /** @test */
    public function user_update()
    {
        $user = App::get('database')->updateWhere('users', [
            'name' => 'FirstUser'
        ], [
            ['name', '=', 'TestUser']
        ]);
        $this->assertNotFalse($user);
        $renamedUser = App::get('database')->selectAllWhere('users', [
            ['name', '=', 'FirstUser'],
        ]);
        $this->assertEquals($renamedUser[0]->name, 'FirstUser');
    }

    /** @test */
    public function users_delete()
    {
        $firstUser = App::get('database')->deleteWhere('users', [
            ['name', '=', 'FirstUser'],
        ]);
        $this->assertTrue($firstUser);
        $firstDeletedUser = App::get('database')->selectAllWhere('users', [
            ['name', '=', 'FirstUser'],
        ]);
        $this->assertEmpty($firstDeletedUser);
        $secondUser = App::get('database')->deleteWhere('users', [
            ['name', '=', 'SecondUser'],
        ]);
        $this->assertTrue($secondUser);
        $secondDeletedUser = App::get('database')->selectAllWhere('users', [
            ['name', '=', 'SecondUser'],
        ]);
        $this->assertEmpty($secondDeletedUser);
    }

}

?>