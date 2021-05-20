<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai_bimbingan_ta extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'nilai_bimbingan_tugas_akhir';

    public function mahasiswa()
    {
        return $this->belongsTo('App\Models\Mahasiswa', 'mhs_id');
    }
}
