<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'spare_part_id', 
        'transaction_type', 
        'quantity', 
        'user_id', 
        'remarks'
    ];

    public function sparePart()
    {
        return $this->belongsTo(SparePart::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
