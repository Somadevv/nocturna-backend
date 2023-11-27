<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Title extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['title'];

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class, 'player_titles');
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
        ];
    }
}
