<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission_counter extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'permission_counter';
    public $timestamps = false;
}
