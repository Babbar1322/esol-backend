<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function test_groups()
    {
        return $this->hasMany(TestGroup::class);
    }

    public function submitted_tests()
    {
        return $this->hasMany(SubmittedTest::class);
    }

    public function user_tests()
    {
        return $this->hasMany(UserTest::class);
    }
}
