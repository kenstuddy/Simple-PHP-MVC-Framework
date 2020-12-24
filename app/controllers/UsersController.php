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
        $users = $user->where([['user_id', '>', '0']], $limit, $offset)->get();
        return view('users', compact('users', 'count', 'page', 'limit'));
    }

    /*
     * This function selects a the user from the users database and then grabs the user view to display them.
     */
    public function show($vars)
    {
        //Here we use the Query Builder to get the user:
        /*$user = App::DB()->selectAllWhere('users', [
            ['user_id', '=', $vars['id']],
        ]);
        */

        //Here we use the ORM to get the user:
        $user = new User();
        $foundUser = $user->find($vars['id']);
        $user = $foundUser ? $foundUser->get() : [];

        if (empty($user)) {
            redirect('users');
        }
        return view('user', compact('user'));
    }

    /*
     * This function inserts a new user into our database using array notation.
     */
    public function store()
    {
        App::DB()->insert('users', [
            'name' => $_POST['name']
        ]);
        return redirect('users');
    }

    /*
     * This function updates a user from our database using array notation.
     */
    public function update($vars)
    {
        App::DB()->updateWhere('users', [
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
        App::DB()->deleteWhere('users', [
            ['user_id', '=', $vars['id']]
        ]);
        return redirect('users');
    }
}

?>
