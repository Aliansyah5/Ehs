<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mitem extends Model
{
    protected $table = 'mitem';
    protected $fillable = ['ItemID', 'Kode', 'Nama', 'KodeNav', 
    'KodeSample', 'NamaOri', 'Jenis', 'Grup', 'Tipe', 'TipeRM',
    'Kat1', 'Kat2', 'Kat3', 'Kat4', 'Merk', 'Warna', 'Berat',
    'BeratJual', 'DefUOM', 'SG', 'Weight', 'Volume', 'Sat', 'Sat2',
    'Sat3', 'Konv', 'Konv2', 'Konv3', 'Harga', 'Harga2', 'Harga3',
    'FileName', 'SamplePrice', 'AvgPrice', 'AvgPriceDate', 'LastPrice',
    'LastPriceDate', 'Margin', 'Panjang', 'Lebar', 'Tinggi', 'DLuar',
    'DDalam', 'HPP', 'Lokasi', 'Foto', 'FileTDS', 'FileMSDS', 'FileCOA',
    'TDSExt', 'MSDSExt', 'COAExt', 'Note', 'SourceNote', 'IsDel', 'StatusID',
    'MinStock', 'KodeVendor', 'NamaVendor', 'SuppID', 'ItemAfkirID', 'CoaID'
    ];

    /**
     * Method One To Many 
     */
    // public function transaksi()
    // {
    // 	return $this->hasMany(Transaksi::class);
    // }
}
