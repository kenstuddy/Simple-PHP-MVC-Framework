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
        $this->assertNotEmpty($testUser);
        $this->assertNotEmpty($secondUser);
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
        $this->assertNotEmpty($user);
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
        $this->assertNotEmpty($firstUser);
        $firstDeletedUser = App::get('database')->selectAllWhere('users', [
            ['name', '=', 'FirstUser'],
        ]);
        $this->assertEmpty($firstDeletedUser);
        $secondUser = App::get('database')->deleteWhere('users', [
            ['name', '=', 'SecondUser'],
        ]);
        $this->assertNotEmpty($secondUser);
        $secondDeletedUser = App::get('database')->selectAllWhere('users', [
            ['name', '=', 'SecondUser'],
        ]);
        $this->assertEmpty($secondDeletedUser);
    }

    /** @test */
    public function user_model_add()
    {
        $user = new User();
        $user = $user->add(['name' => 'TestUser']);
        $this->assertEquals($user->first()->name, 'TestUser');
        $user = $user->find([['name', '=', 'TestUser']]);
        $foundUser = $user ? $user->first() : null;
        $this->assertEquals($foundUser->name, 'TestUser');
    }

    /** @test */
    public function user_model_index()
    {
        $users = User::all();
        $this->assertNotEmpty($users);
    }

    /** @test */
    public function user_model_first_or_fail()
    {
        $user = new User();
        $user->find([['name', '=', 'TestUser']]);
        $user = $user ? $user->firstOrFail() : null;
        $this->assertNotEmpty($user);
    }

    /** @test */
    public function user_model_find_or_fail()
    {
        $user = new User();
        $user = $user->findOrFail([['name', '=', 'TestUser']]);
        $this->assertNotEmpty($user);
    }

    /** @test */
    public function users_raw_query()
    {
        $unnamedUsers = App::get('database')->raw('SELECT * FROM users WHERE user_id > ?', [0]);
        $this->assertNotEmpty(count($unnamedUsers));
        $namedUsers = App::get('database')->raw('SELECT * FROM users WHERE user_id > :user_id', ['user_id' => 0]);
        $this->assertNotEmpty(count($namedUsers));
        $newUser = App::get('database')->raw('INSERT INTO users(name) VALUES (?)', ['TestingUser']);
        $this->assertNotEmpty($newUser);
        $deleteUser = App::get('database')->raw('DELETE FROM users WHERE name = :name', ['name' => 'TestingUser']);
        $this->assertNotEmpty($deleteUser);
        $deletedUser = App::get('database')->raw('SELECT * FROM users WHERE name = ?', ['TestingUser']);
        $this->assertEmpty(count($deletedUser));
    }

    /** @test */
    public function user_model_update()
    {
        $user = new User();
        $user->updateWhere(['name' => 'SomeUser'], [['name', '=', 'TestUser']]);
        $user = $user->find([['name', '=', 'SomeUser']]);
        $updatedUser = $user ? $user->first() : null;
        $this->assertEquals($updatedUser->name, 'SomeUser');
    }

    /** @test */
    public function user_model_save()
    {
        $user = new User();
        $user = $user->find([['name', '=', 'SomeUser']]);
        $foundUser = $user ? $user->first() : null;
        $this->assertEquals($foundUser->name, 'SomeUser');
        $foundUser->name = 'ThisUser';
        $foundUser->save();
        $this->assertEquals($user->first()->name, 'ThisUser');
    }

    /** @test */
    public function user_model_delete()
    {
        $user = new User();
        $user->deleteWhere([['name', '=', 'ThisUser']]);
        $deletedUser = $user->find([['name', '=', 'ThisUser']]);
        $this->assertNull($deletedUser);
    }

    /** @test */
    public function project_model_add()
    {
        $project = new Project();
        $project = $project->add(['name' => 'TestProject']);
        $this->assertEquals($project->first()->name, 'TestProject');
        $project = $project->find([['name', '=', 'TestProject']]);
        $foundProject = $project ? $project->first() : null;
        $this->assertEquals($foundProject->name, 'TestProject');

    }

    /** @test */
    public function project_model_save()
    {
        $project = new Project();
        $project = $project->find([['name', '=', 'TestProject']]);
        $foundProject = $project ? $project->first() : null;
        $this->assertEquals($foundProject->name, 'TestProject');
        $foundProject->name = 'SomeProject';
        $foundProject->save();
        $this->assertEquals($project->first()->name, 'SomeProject');
    }

    /** @test */
    public function project_model_index()
    {
        $projects = Project::all();
        $this->assertNotEmpty($projects);
    }

     /** @test */
    public function projects_raw_query()
    {
        $unnamedProjects = App::get('database')->raw('SELECT * FROM projects WHERE project_id > ?', [0]);
        $this->assertNotEmpty(count($unnamedProjects));
        $namedProjects = App::get('database')->raw('SELECT * FROM projects WHERE project_id > :project_id', ['project_id' => 0]);
        $this->assertNotEmpty(count($namedProjects));
        $newProject = App::get('database')->raw('INSERT INTO projects(name) VALUES (?)', ['TestingProject']);
        $this->assertNotEmpty($newProject);
        $deleteProject = App::get('database')->raw('DELETE FROM projects WHERE name = :name', ['name' => 'TestingProject']);
        $this->assertNotEmpty($deleteProject);
        $deletedProject = App::get('database')->raw('SELECT * FROM projects WHERE name = ?', ['TestingProject']);
        $this->assertEmpty(count($deletedProject));
    }

    /** @test */
    public function project_model_delete()
    {
        $project = new Project();
        $project->deleteWhere([['name', '=', 'TestProject']]);
        $deletedProject = $project->find([['name', '=', 'TestProject']]);
        $this->assertNull($deletedProject);
    }

    /** @test */
    public function users_model_paginate()
    {
        $user = new User();
        for ($i = 0; $i < 5; $i++) {
            $user->add(['name' => 'TestUser']);
        }
        $num = $user->count();
        $this->assertNotEmpty($num);
        $numMany = $user->count([['user_id', '>', '3']]);
        $this->assertNotEmpty($numMany);
        $page = 1;
        $limit = 2;
        $pageOneUser = new User();
        $pageOneUsers = $pageOneUser->find([['user_id', '>', '0']], $limit, ($page - 1) * $limit);
        $this->assertNotNull($pageOneUsers);
        $this->assertCount(2, $pageOneUsers ? $pageOneUsers->get() : null);
        $page = 2;
        $pageTwoUser = new User();
        $pageTwoUsers = $pageTwoUser->find([['user_id', '>', '0']], $limit, ($page - 1) * $limit);
        $this->assertNotNull($pageTwoUsers);
        $this->assertCount(2, $pageTwoUsers ? $pageTwoUsers->get() : null);
        $this->assertNotEquals($pageTwoUsers ? $pageTwoUsers->first()->user_id : null, $pageOneUsers ? $pageOneUsers->first()->user_id : null);
        $user->deleteWhere([['name', '=', 'TestUser']]);
        $deletedUsers = $user->find([['name', '=', 'TestUser']]);
        $this->assertNull($deletedUsers);
    }
}

?>