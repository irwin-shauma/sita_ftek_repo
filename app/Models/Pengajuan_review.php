<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan_review extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'pengajuan_review';

    public function mahasiswa()
    {
        return $this->belongsTo('App\Models\Mahasiswa', 'mhs_id');
    }
}
