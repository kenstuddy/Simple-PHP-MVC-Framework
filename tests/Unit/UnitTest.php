<?php

namespace tests\Unit;

use tests\TestCase;
use App\Core\{Router, Request, App};
use App\Models\User;
use App\Models\Project;

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
    public function users_limit()
    {
        $count = 2;
        $users = App::get('database')->selectAll('users', $count);
        $this->assertCount($count, $users);
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

    /** @test */
    public function user_model_add()
    {
        $user = new User();
        $user->add(['name' => 'TestUser']);
        $foundUser = $user->find([['name', '=', 'TestUser']])->first();
        $this->assertEquals($foundUser->name, 'TestUser');
    }

    /** @test */
    public function user_model_index()
    {
        $users = User::all();
        $this->assertNotEmpty($users);
    }

    /** @test */
    public function user_model_update()
    {
        $user = new User();
        $user->updateWhere(['name' => 'SomeUser'], [['name', '=', 'TestUser']]);
        $updatedUser = $user->find([['name', '=', 'SomeUser']])->first();
        $this->assertEquals($updatedUser->name, 'SomeUser');
    }

    /** @test */
    public function user_model_delete()
    {
        $user = new User();
        $user->deleteWhere([['name', '=', 'SomeUser']]);
        $deletedUser = $user->find([['name', '=', 'TestUser']])->first();
        $this->assertEmpty($deletedUser);
    }

    /** @test */
    public function project_model_add()
    {
        $project = new Project();
        $project->add(['name' => 'TestProject']);
        $foundProject = $project->find([['name', '=', 'TestProject']])->first();
        $this->assertEquals($foundProject->name, 'TestProject');
    }

    /** @test */
    public function project_model_index()
    {
        $projects = Project::all();
        $this->assertNotEmpty($projects);
    }

    /** @test */
    public function project_model_delete()
    {
        $project = new Project();
        $project->deleteWhere([['name', '=', 'TestProject']]);
        $deletedProject = $project->find([['name', '=', 'TestProject']])->first();
        $this->assertEmpty($deletedProject);
    }

}

?>