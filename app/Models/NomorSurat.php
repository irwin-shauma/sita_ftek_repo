<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wuwx\LaravelAutoNumber\AutoNumberTrait;
use Carbon\Carbon;
use Terbilang;

class NomorSurat extends Model
{
    // use HasFactory, AutoNumberTrait;
    use HasFactory;

    protected $guarded = [];

    // public function getAutoNumberOptions()
    // {
    //     return [
    //         'number' => [
    //             'format' => 'SO.?/',
    //             'length' => 1
    //         ]
    //     ];
    // }

    protected $table = 'nomor_surat';
}
