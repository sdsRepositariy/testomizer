<?php

namespace App\Models\Tests;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tests\TestItem as TestItem;

class TestFolder extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
    */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = ['name', 'description', 'test_folder_id'];

    /**------------Model relationships------------*/

    /**
     * Get the test list for the folder.
     */
    public function testItems()
    {
        return $this->hasMany(TestItem::class);
    }

    /**
    * Get the parent folder.
    */
    public function parent()
    {
        return $this->belongsTo(__CLASS__, 'test_folder_id');
    }

    /**
     * Get the chidren folders.
    */
    public function children()
    {
        return $this->hasMany(__CLASS__);
    }
}
