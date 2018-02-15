<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tasks\TaskList as TaskList;

class TaskFolder extends Model
{
	/**------------Model relationships------------*/

    /**
     * Get the task list for the folder.
     */
    public function getTaskList()
    {
        return $this->hasMany(TaskList::class);
    }
}
