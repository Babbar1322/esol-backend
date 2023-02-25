<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestGroup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tests()
    {
        return $this->belongsTo(Test::class);
    }
    public function test_questions()
    {
        return $this->hasMany(TestQuestions::class);
    }
}
