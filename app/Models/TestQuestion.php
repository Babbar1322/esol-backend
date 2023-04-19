<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'answer'
    ];

    public function test_groups()
    {
        return $this->belongsTo(TestGroup::class);
    }
}
