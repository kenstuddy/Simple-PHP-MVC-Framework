<?php
/*
 * This is the starting point for a Project model.
 */
namespace App\Models;

use App\Core\Database\Model;

class Project extends Model
{
    protected static $table = 'projects';
    
    public $project_id;
    
    public $name;
}


?>
