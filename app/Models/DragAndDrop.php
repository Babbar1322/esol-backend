<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DragAndDrop extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function test_group()
    {
        return $this->belongsTo(TestGroup::class);
    }

    public function test_questions()
    {
        return $this->hasMany(TestQuestion::class);
    }
}
