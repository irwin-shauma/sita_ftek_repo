<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kolokium_lanjut extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'kolokium_lanjut';

    public function mahasiswa()
    {
        return $this->belongsTo('App\Models\Mahasiswa', 'mhs_id');
    }
}
