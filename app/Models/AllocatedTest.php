<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllocatedTest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function test()
    {
        return $this->belongsTo(CombineTest::class, 'combined_test_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
