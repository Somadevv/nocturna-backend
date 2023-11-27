<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;


    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function players()
    {
        return $this->belongsToMany(Player::class, 'inventory', 'item_id', 'player_id');
    }
}
