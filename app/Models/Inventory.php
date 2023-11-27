<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = ['player_id', 'item_id', 'quantity'];
    public $timestamps = false;
    protected $table = 'inventory';


    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
