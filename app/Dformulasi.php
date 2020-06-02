<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dformulasi extends Model
{
    protected $table = 'dformulasi';
    protected $fillable = ['FormID', 'Idx', 'ItemID', 'ItemName', 
    'QtyStd', 'Konv', 'Sat', 'Toleransi', 'HP', 'SG',
    'WT', 'PersenWT', 'Vol', 'HPP', 'PersenHPP', 'Note'
    ];

    /**
     * Method One To Many 
     */
    // public function transaksi()
    // {
    // 	return $this->hasMany(Transaksi::class);
    // }
}
