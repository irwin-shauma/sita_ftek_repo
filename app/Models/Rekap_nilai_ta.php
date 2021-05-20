<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekap_nilai_ta extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'rekap_nilai_tugas_akhir';

    public function mahasiswa()
    {
        return $this->belongsTo('App\Models\Mahasiswa', 'mhs_id');
    }
}
