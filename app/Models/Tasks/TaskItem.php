<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tasks\TaskItem as TaskItem;

class TaskItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = ['user_id', 'name', 'description', 'task_folder_id'];
}
