<?php

namespace App\Controllers;
use App\Core\App;
class UsersController
{

    /*
     * This function selects all the users from the users database and then grabs the users view to display them.
     */
    public function index()
    {
        $users = App::get('database')->selectAll('users');
        return view('users', compact('users'));
    }
    /*
     * This function inserts a new user into our database.
     */
    public function store()
    {
        App::get('database')->insert('users',[
            'name' => $_POST['name']
        ]);
        return redirect('users');
    }
}

 ?>
