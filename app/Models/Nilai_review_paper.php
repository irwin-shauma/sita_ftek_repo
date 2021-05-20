<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai_review_paper extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'nilai_review_paper';

    public function mahasiswa()
    {
        return $this->belongsTo('App\Models\Mahasiswa', 'mhs_id');
    }
}
