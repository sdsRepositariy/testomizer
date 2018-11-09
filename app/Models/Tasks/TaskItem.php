<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tasks\TaskFolder as TaskFolder;

class TaskItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = ['user_id', 'name', 'description', 'task_folder_id'];

    /**
     * Get the folder that owns the task.
    */
    public function taskFolder()
    {
        return $this->belongsTo(TaskFolder::class);
    }
}
