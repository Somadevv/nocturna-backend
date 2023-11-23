<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Player extends Authenticatable
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

    public function setActiveTitle($titleId)
    {
        $this->active_title_id = $titleId;
    }
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
    
}
