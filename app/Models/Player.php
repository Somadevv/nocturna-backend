<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Player extends Authenticatable implements JWTSubject

{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
    public $timestamps = false;


    public function titles(): BelongsToMany
    {
        return $this->belongsToMany(Title::class, 'player_titles');
    }

    public function activeTitle()
    {
        return $this->belongsTo(Title::class, 'active_title_id');
    }

    public function unlockedTitles()
    {
        return $this->belongsToMany(Title::class, 'player_titles');
    }

    public function inventory()
    {
        return $this->belongsToMany(Item::class, 'inventory', 'player_id', 'item_id')->withPivot('quantity');
    }

    // JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email' => $this->email,
            'name' => $this->name
        ];
    }
}
