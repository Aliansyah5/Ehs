<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dformula extends Model
{
    protected $table = 'dformula';
    protected $fillable = ['FormID', 'Idx', 'ProjectID', 'FormulasiIdx', 
    'ItemID', 'ItemName', 'QtyStd', 'Konv', 'Sat', 'Toleransi',
    'HP', 'SG', 'WT', 'PersenWT', 'Vol', 'HPP', 'PersenHPP',
    'HP1', 'SG1', 'WT1', 'PersenWT1', 'Vol1', 'HPP1', 'PersenHPP1',
    'Note'
    ];

    public $timestamps = false;         
    /**
     * Method One To Many 
     */
    // public function transaksi()
    // {
    // 	return $this->hasMany(Transaksi::class);
    // }
}
