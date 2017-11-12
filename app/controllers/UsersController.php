<?php

/*
 * This is the users controller. It adds returns the view for the users list portion of this framework (which happens to
 * be the index page).
 */

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
        return view('Users', compact('users'));
    }
    /*
     * This function inserts a new user into our database using array notation.
     */
    public function store()
    {
        App::get('database')->insert('users',[
            'name' => $_POST['name']
        ]);
        return redirect('Users');
    }
}

 ?>
