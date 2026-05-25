<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SparePart extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'part_number', 
        'category_id', 
        'machine_id', 
        'stock_quantity', 
        'min_stock_level', 
        'max_stock_level', 
        'reorder_point', 
        'unit_price'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }
}
