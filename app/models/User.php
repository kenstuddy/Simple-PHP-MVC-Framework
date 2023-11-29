<?php
/*
 * This is the starting point for a User model.
 */
namespace App\Models;

use App\Core\Database\Model;

class User extends Model
{
    protected static $table = 'users';
    
    public $user_id;
    
    public $name;
    
}


?>
