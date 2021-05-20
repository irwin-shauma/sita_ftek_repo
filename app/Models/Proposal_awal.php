<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal_awal extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'proposal_awal';

    public function mahasiswa()
    {
        return $this->belongsTo('App\Models\Mahasiswa', 'mhs_id');
    }
}
