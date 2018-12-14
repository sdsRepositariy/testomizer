<?php

namespace App\Models\Tests;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tests\TestFolder as TestFolder;

class TestItem extends Model
{
    /**
     * Get the folder that owns the test.
    */
    public function testFolder()
    {
        return $this->belongsTo(TestFolder::class);
    }
}
