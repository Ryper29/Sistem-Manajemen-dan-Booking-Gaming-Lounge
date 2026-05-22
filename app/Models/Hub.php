<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hub extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk memberikan "izin masuk" pada data
    protected $fillable = [
        'hub_number', 
        'tier', 
        'facilities', 
        'price_per_hour', 
        'status'
    ];

    // Mendefinisikan Relasi: 1 Hub bisa punya banyak Transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}