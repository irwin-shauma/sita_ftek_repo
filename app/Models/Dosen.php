<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';

    protected $fillable = [
        'name',
        'nip'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function mahasiswas()
    {
        return $this->belongsToMany(Mahasiswa::class, 'pembimbing', 'mhs_id', 'dosen1_id')->withPivot('mhs_id', 'dosen1_id', 'dosen2_id')->using(Pembimbing::class)->withTimestamps();
        // return $this->belongsToMany(Mahasiswa::class, 'pembimbing', 'mhs_id', 'dosen1_id')->using(Pembimbing::class)->withTimestamps();
    }

    public function mahasiswa_review()
    {
        return $this->belongsToMany(Mahasiswa::class, 'reviewer', 'mhs_id', 'reviewer1_id')->withPivot('mhs_id', 'reviewer1_id', 'reviewer2_id')->using(Reviewer::class)->withTimestamps();
    }
}
