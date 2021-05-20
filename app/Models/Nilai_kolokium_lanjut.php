<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai_kolokium_lanjut extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'nilai_kolokium_lanjut';

    public function mahasiswa()
    {
        return $this->belongsTo('App\Models\Mahasiswa', 'mhs_id');
    }
    public function dosen()
    {
        return $this->belongsToMany('App\Models\Dosen', 'reviewer_id');
    }
}
