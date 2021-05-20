<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Pembimbing extends Pivot
{
    use HasFactory;

    // protected $guarded = [];

    // protected $table = 'pembimbing';

    public $incrementing = true;
}
