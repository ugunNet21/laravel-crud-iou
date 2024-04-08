<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BSREData extends Model
{
    use HasFactory;
    protected $table  = 'bsre_data';
    protected $fillable = [
        'nik',
        'passphrase',
        'tampilan',
        'page',
        'image',
        'linkQR',
        'xAxis',
        'yAxis',
        'width',
        'height',
        'file',
        'tag_koordinat',
        'id_dokumen',
        'file_keterangan_dtks_sudtks'
    ];
}
