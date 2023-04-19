<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CombineTest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function reading_test()
    {
        return $this->belongsTo(Test::class, 'reading_test_id');
    }

    public function writing_test()
    {
        return $this->belongsTo(Test::class, 'writing_test_id');
    }

    public function listening_test()
    {
        return $this->belongsTo(Test::class, 'listening_test_id');
    }
}
