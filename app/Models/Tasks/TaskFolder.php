<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tasks\TaskItem as TaskItem;

class TaskFolder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = ['user_id', 'name', 'description', 'task_folder_id'];

    /**------------Model relationships------------*/

    /**
     * Get the task list for the folder.
     */
    public function taskItems()
    {
        return $this->hasMany(TaskItem::class);
    }

    /**
    * Get the parent folder.
    */
    public function parent()
    {
        return $this->belongsTo(__CLASS__, 'task_folder_id');
    }

    /**
     * Get the chidren folder.
    */
    public function children()
    {
        return $this->hasMany(__CLASS__);
    }
}
