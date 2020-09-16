<?php

/*
 * This is the users controller. It adds returns the view for the users list portion of this framework.
 */

namespace App\Controllers;

use App\Core\App;
use App\Models\User;

class UsersController
{

    /*
     * This function selects all the users from the users database and then grabs the users view to display them.
     */
    public function index($vars = [])
    {
        $user = new User();
        $count = $user->count();
        $limit = 5;
        $page = $vars['page'] ?? 1;
        $offset = ($page - 1) * $limit;
        $users = $user->find([['user_id', '>', '0']], $limit, $offset)->get();
        return view('users', compact('users', 'count', 'page', 'limit'));
    }

    /*
     * This function selects a the user from the users database and then grabs the user view to display them.
     */
    public function show($vars)
    {
        $user = App::get('database')->selectAllWhere('users', [
            ['user_id', '=', $vars['id']],
        ]);
        return view('user', compact('user'));
    }

    /*
     * This function inserts a new user into our database using array notation.
     */
    public function store()
    {
        App::get('database')->insert('users', [
            'name' => $_POST['name']
        ]);
        return redirect('users');
    }

    /*
     * This function updates a user from our database using array notation.
     */
    public function update($vars)
    {
        App::get('database')->updateWhere('users', [
            'name' => $_POST['name']
        ], [
            ['user_id', '=', $vars['id']]
        ]);
        return redirect('user/' . $vars['id']);
    }

    /*
     * This function deletes a user from our database.
     */
    public function delete($vars)
    {
        App::get('database')->deleteWhere('users', [
            ['user_id', '=', $vars['id']]
        ]);
        return redirect('users');
    }
}

?>
