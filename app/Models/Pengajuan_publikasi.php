<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan_publikasi extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'pengajuan_publikasi';

    public function mahasiswa()
    {
        return $this->belongsTo('App\Models\Mahasiswa', 'mhs_id');
    }
}
