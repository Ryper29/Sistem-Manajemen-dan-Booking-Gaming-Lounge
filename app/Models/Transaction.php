<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hub_id', 
        'customer_name', 
        'duration_hours', 
        'add_on_name',
        'add_on_price',
        'total_price', 
        'start_time', 
        'end_time', 
        'status'
    ];

    // Mendefinisikan Relasi: 1 Transaksi ini milik 1 Hub
    public function hub()
    {
        return $this->belongsTo(Hub::class);
    }
}