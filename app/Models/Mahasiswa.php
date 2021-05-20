<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Mahasiswa extends Model
{
    use HasFactory;


    protected $table = 'mahasiswa';

    protected $fillable = [
        'name',
        'nim',
        'progress',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function kolokium_awal()
    {
        return $this->hasOne('App\Models\Kolokium_awal', 'id');
    }

    public function kolokium_lanjut()
    {
        return $this->hasOne('App\Models\Kolokium_lanjut', 'id');
    }
    public function pengajuan_review()
    {
        return $this->hasOne('App\Models\Pengajuan_review', 'id');
    }
    public function pengajuan_publikasi()
    {
        return $this->hasOne('App\Models\Pengajuan_publikasi', 'id');
    }
    public function proposal_awal()
    {
        return $this->hasMany('App\Models\Proposal_awal', 'id');
    }
    public function proposal_lanjut()
    {
        return $this->hasMany('App\Models\Proposal_lanjut', 'id');
    }
    public function paper_review()
    {
        return $this->hasMany('App\Models\Paper_review', 'id');
    }

    public function nilai_kolokium_lanjut()
    {
        return $this->hasOne('App\Models\Nilai_kolokium_lanjut', 'id');
    }

    public function dosens()
    {
        return $this->belongsToMany(Dosen::class, 'pembimbing', 'mhs_id', 'dosen1_id')->withPivot('mhs_id', 'dosen1_id', 'dosen2_id')->using(Pembimbing::class)->withTimestamps();
        //Using() itu buat pake model pembimbingnya
        //
        // return $this->belongsToMany(Dosen::class, 'pembimbing', 'mhs_id', 'dosen1_id')->using(Pembimbing::class)->withTimestamps();
    }

    public function dosen_review()
    {
        return $this->belongsToMany(Dosen::class, 'reviewer', 'mhs_id', 'reviewer1_id')->withPivot('mhs_id', 'reviewer1_id', 'reviewer2_id')->using(Reviewer::class)->withTimestamps();
        // return $this->belongsToMany(Dosen::class, 'reviewer', 'mhs_id', 'reviewer_id')->using(Reviewer::class);
    }
}
